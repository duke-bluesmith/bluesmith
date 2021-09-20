<?php

namespace App\Libraries;

use App\Entities\Notice;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use Countable;
use Generator;
use IteratorAggregate;
use Tatter\Chat\Models\MessageModel;
use Traversable;

/**
 * Notices Class
 *
 */
final class Notices implements Countable, IteratorAggregate
{
	/**
	 * The collection of Notices.
	 *
	 * @var Notice[]
	 */
	protected $notices = [];

	/**
	 * Creates a new instance from cache - falls back to detection.
	 *
	 * @return self
	 */
	public static function createFromCache()
	{
		return new self(cache('notices'));
	}

	/**
	 * Loads the Filesystem helper and adds any initial files.
	 *
	 * @param Notice[] $notices Any initial notices
	 */
	public function __construct(?array $notices = null)
	{
		$this->notices = $notices;

		if ($notices === null)
		{			
			$this->detect();
		}
	}

	/**
	 * Scans for and stores each Notice
	 */
	public function detect(): void
	{
		$this->notices = [];

		$this->getFromStaffJobs();
		$this->getFromClientChats();

		cache()->save('notices', $this->notices);
	}

	/**
	 * Detecs all active Jobs awaiting staff action.
	 */
	private function getFromStaffJobs(): void
	{
		foreach (model(JobModel::class)->builder()
			->select('jobs.*, actions.summary, users.id AS user_id, users.firstname, users.lastname')
			->join('jobs_users', 'jobs.id = jobs_users.job_id', 'left')
			->join('users', 'jobs_users.user_id = users.id', 'left')
			->join('stages', 'jobs.stage_id = stages.id', 'left')
			->join('actions', 'stages.action_id = actions.id', 'left')
			->where('jobs.deleted_at', null)
			->where('actions.role', 'manageJobs')
			->get()->getResultArray() as $row)
		{
			$this->notices[$row['id']] = new Notice([
				'job_id'     => $row['id'],
				'job_name'   => $row['name'],
				'user_id'    => $row['user_id'],
				'user_name'  => $row['firstname'] . ' ' . $row['lastname'],
				'status'     => 'Awaiting Staff',
				'content'    => $row['summary'] ?: '[empty]',
				'created_at' => $row['updated_at'],
			]);
		}
	}

	/**
	 * Detects all recent client Chat activity.
	 */
	private function getFromClientChats(): void
	{
		// Get all "Staff"
		if (! $staff = model(UserModel::class)->findStaffIds())
		{
			return;
		}

		helper(['text']);
		$messages = [];

		// Get the last week of messages
		$rows = model(MessageModel::class)
			->select('chat_messages.*, chat_conversations.uid, chat_participants.user_id')
			->join('chat_conversations', 'chat_messages.conversation_id = chat_conversations.id')
			->join('chat_participants', 'chat_messages.participant_id = chat_participants.id')
			->like('chat_conversations.uid', 'job-%')
			->where('chat_messages.created_at >', new Time('-1 week'))
			->get()->getResultArray();

		// Only keep messages without a staff response
		foreach ($rows as $row)
		{
			[, $jobId] = explode('-', $row['uid']);

			if (in_array($row['user_id'], $staff))
			{
				unset($messages[$jobId]);
			}
			else
			{
				$messages[$jobId] = $row;
			}
		}

		// Create Notices from the remaining rows
		foreach ($messages as $jobId => $row)
		{
			$job  = model(JobModel::class)->withDeleted()->find($jobId);
			$user = model(UserModel::class)->withDeleted()->find($row['user_id']);

			$this->notices[$jobId] = new Notice([
				'job_id'     => $job->id,
				'job_name'   => $job->name,
				'user_id'    => $user->id,
				'user_name'  => $user->name,
				'status'     => 'Client Message',
				'content'    => character_limiter($row['content'], 100) ?: '[empty]',
				'created_at' => $row['created_at'],
			]);
		}
	}

	/**
	 * Pushes a new Notice into the collection
	 *
	 * @return $this
	 */
	final public function push(Notice $notice)
	{
		$this->notices[$notice->job_id] = $notice;

		return $this;
	}

	/**
	 * Optimizes and returns the Notices.
	 *
	 * @return Notice[]
	 */
	protected function get(): array
	{
		$sort = array_column($this->notices, 'sort');
		array_multisort($sort, SORT_DESC, SORT_NUMERIC, $this->notices, SORT_DESC);

		return $this->notices;
	}

	//--------------------------------------------------------------------
	// Interface Methods
	//--------------------------------------------------------------------

    /**
     * Returns the current number of Notices in the collection.
     * Fulfills Countable.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->get());
    }

    /**
     * Yields as an Iterator for the current Notices.
     * Fulfills IteratorAggregate.
     *
     * @return Generator<Notice>
     */
    public function getIterator(): Generator
    {
    	foreach ($this->get() as $notice)
    	{
    		yield $notice;
    	}
    }
}

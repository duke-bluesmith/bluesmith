<?php

namespace App\Libraries;

use App\Entities\Notification;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use Countable;
use Generator;
use IteratorAggregate;
use Tatter\Chat\Models\MessageModel;
use Traversable;

/**
 * Notifications Class
 *
 */
final class Notifications implements Countable, IteratorAggregate
{
	/**
	 * The collection of Notifications.
	 *
	 * @var Notification[]
	 */
	protected $notifications = [];

	/**
	 * Creates a new instance from cache - falls back to detection.
	 *
	 * @return self
	 */
	public static function createFromCache()
	{
		return new self(cache('notifications'));
	}

	/**
	 * Loads the Filesystem helper and adds any initial files.
	 *
	 * @param Notification[] $notifications Any initial notifications
	 */
	public function __construct(?array $notifications = null)
	{
		$this->notifications = $notifications;

		if ($notifications === null)
		{			
			$this->detect();
		}
	}

	/**
	 * Scans for and stores each Notification
	 */
	public function detect(): void
	{
		$this->notifications = [];

		$this->getFromStaffJobs();
		$this->getFromClientChats();

		cache()->save('notifications', $this->notifications);
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
			$this->notifications[$row['id']] = new Notification([
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

		// Create Notifications from the remaining rows
		foreach ($messages as $jobId => $row)
		{
			$job  = model(JobModel::class)->find($jobId);
			$user = model(UserModel::class)->find($row['user_id']);

			$this->notifications[$jobId] = new Notification([
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
	 * Pushes a new Notification into the collection
	 *
	 * @return $this
	 */
	final public function push(Notification $notification)
	{
		$this->notifications[$notification->job_id] = $notification;

		return $this;
	}

	/**
	 * Optimizes and returns the Notifications.
	 *
	 * @return Notification[]
	 */
	protected function get(): array
	{
		$sort = array_column($this->notifications, 'sort');
		array_multisort($sort, SORT_DESC, SORT_NUMERIC, $this->notifications, SORT_DESC);

		return $this->notifications;
	}

	//--------------------------------------------------------------------
	// Interface Methods
	//--------------------------------------------------------------------

    /**
     * Returns the current number of Notifications in the collection.
     * Fulfills Countable.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->get());
    }

    /**
     * Yields as an Iterator for the current Notifications.
     * Fulfills IteratorAggregate.
     *
     * @return Generator<Notification>
     */
    public function getIterator(): Generator
    {
    	foreach ($this->get() as $notification)
    	{
    		yield $notification;
    	}
    }
}

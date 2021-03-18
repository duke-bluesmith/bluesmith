<?php namespace App\Models;

use App\Entities\Job;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use Tatter\Workflows\Models\JobModel as BaseJobModel;

/**
 * Class JobModel
 *
 * Extension of the Workflows model to add Relations and Permits
 *
 */
class JobModel extends BaseJobModel
{
	// Traits
	use \Tatter\Permits\Traits\PermitsTrait;
	use \Tatter\Relations\Traits\ModelTrait;

	protected $with		     = ['options'];
	protected $returnType	 = Job::class;
	protected $allowedFields = ['name', 'summary', 'workflow_id', 'stage_id', 'material_id'];

	protected $afterInsert = ['clearCompiledRows'];
	protected $afterUpdate = ['clearCompiledRows'];
	protected $afterDelete = ['clearCompiledRows'];

	/**
	 * Permits
	 * 6 Domain list and create
	 * 6 Owner  read, write
	 * 6 Group  read, write
	 * 0 World  no read, no write
	 */	
	protected $mode = 06660;
	
	// Table that joins this model's objects to its users
	protected $usersPivot = 'jobs_users';
	
	// Name of this object's ID in the pivot tables
	protected $pivotKey = 'job_id';

	/**
	 * Assigns a single Email to a single job.
	 *
	 * @param int $emailId
	 * @param int $jobId
	 *
	 * @return bool
	 */
	public function addEmailToJob(int $emailId, int $jobId): bool
	{
		return (bool) $this->db->table('emails_jobs')->insert([
			'email_id' => (int) $emailId,
			'job_id'   => (int) $jobId,
		]);
	}

	/**
	 * Assigns a single User to a single job.
	 *
	 * @param int $userId
	 * @param int $jobId
	 *
	 * @return bool
	 */
	public function addUserToJob(int $userId, int $jobId): bool
	{
		return (bool) $this->db->table('jobs_users')->insert([
			'job_id'     => (int) $jobId,
			'user_id'    => (int) $userId,
			'created_at' => date('Y-m-d H:i:s'),
		]);
	}

	/**
	 * Removes cached Job rows.
	 *
	 * @return void
	 */
	public function clearCompiledRows(): void
	{
		cache()->delete('jobrows');
	}

	/**
	 * Fetch or build the Job rows for browsing,
	 * applying filters and sorting.
	 *
	 * @param callable|null $filter
	 * @param string $sort
	 * @param bool $ascending
	 *
	 * @return array[]
	 */
	public function getCompiledRows(callable $filter = null, string $sort = 'id', bool $ascending = true): array
	{
		if (! $rows = cache('jobrows'))
		{
			// Pull all the data
			$result = $this->builder()
				->select('jobs.*, users.id AS user_id, users.firstname, users.lastname, workflows.name AS workflow, actions.name AS action, actions.role')
				->join('jobs_users', 'jobs.id = jobs_users.job_id', 'left')
				->join('users', 'jobs_users.user_id = users.id')
				->join('workflows', 'jobs.workflow_id = workflows.id')
				->join('stages', 'jobs.stage_id = stages.id', 'left')
				->join('actions', 'stages.action_id = actions.id')
				->get()->getResultArray();

			// Process into rows
			$rows = [];
			foreach ($result as $row)
			{
				// Only keep the first match (from multiple Users join)
				if (isset($rows[$row['id']]))
				{
					continue;
				}

				$rows[$row['id']] = $row;
			}

			// Convert timestamps to Time
			$rows = array_map(function ($row) {
				$row['created_at'] = new Time($row['created_at']);
				$row['updated_at'] = new Time($row['updated_at']);

				if (isset($row['deleted_at']))
				{
					$row['deleted_at'] = new Time($row['deleted_at']);
				}

				return $row;
			}, $rows);

			// Cache the rows
			$rows = array_values($rows);
			cache()->save('jobrows', $rows, HOUR);
		}

		// Filter the array with the callable, or `null` which removes empties
		$rows = $filter ? array_filter($rows, $filter) : array_filter($rows);

		// Short circuit for unsortable results
		if (count($rows) < 2)
		{
			return $rows;
		}

		// Check for a valid sort request
		if (array_key_exists($sort, reset($rows)))
		{
			usort($rows, function ($row1, $row2) use ($sort, $ascending) {
				return $ascending
					? $row1[$sort] <=> $row2[$sort]
					: $row2[$sort] <=> $row1[$sort];
			});
		}

		return $rows;
	}

	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return Job
	 */
	public function fake(Generator &$faker): Job
	{
		return new Job([
			'name'        => $faker->catchPhrase,
			'summary'     => $faker->sentence,
			'workflow_id' => rand(1, Fabricator::getCount('workflows') ?: 4),
			'stage_id'    => rand(1, Fabricator::getCount('stages')    ?: 99),
			'material_id' => rand(1, Fabricator::getCount('materials') ?: 35),
		]);
	}
}

<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\JobModel;
use CodeIgniter\I18n\Time;

class Jobs extends BaseController
{
	/**
	 * @var JobModel
	 */
	protected $model;

	/**
	 * Load the JobModel
	 */
	public function __construct()
	{
		$this->model = model(JobModel::class);
	}

	/**
	 * Display the list of all JobRows
	 *
	 * @return string
	 */
	public function index()
	{
		return view('jobs/index', [
			'title' => 'Active Jobs',
			'rows'  => $this->getJobRows(null, 'updated_at', false),
		]);
	}

	/**
	 * Display the list of active JobRows
	 *
	 * @return string
	 */
	public function active()
	{
		return view('jobs/index', [
			'title' => 'Active Jobs',
			'rows'  => $this->getJobRows(function($row) {
				return is_null($row['deleted_at']);
			}, 'stage_id')
		]);	
	}

	/**
	 * Display the list of active JobRows awaiting staff input
	 *
	 * @return string
	 */
	public function staff()
	{
		return view('jobs/index', [
			'title' => 'Active Jobs',
			'rows'  => $this->getJobRows(function($row) {
				return is_null($row['deleted_at']) && $row['role'] === 'manageJobs';
			}, 'stage_id')
		]);	
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
	private function getJobRows(callable $filter = null, string $sort = 'id', bool $ascending = true): array
	{
		if (! $rows = cache('jobrows'))
		{
			// Pull all the data
			$result = $this->model->builder()
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
}

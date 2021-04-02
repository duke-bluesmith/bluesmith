<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\JobModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use Tatter\Workflows\Models\JoblogModel;
use Closure;

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
	 * Displays a single Job with management options.
	 *
	 * @param string|int|null $jobId
	 *
	 * @return string
	 */
	public function show($jobId = null): string
	{
		if (is_null($jobId) || ! $job = $this->model->withDeleted()->find($jobId))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		return view('jobs/show', [
			'title' => 'Job Details',
			'job'   => $job,
			'logs'  => model(JoblogModel::class)->findWithStages($job->id),
		]);
	}

	/**
	 * Displays the compiled rows awaiting staff input
	 *
	 * @return string
	 */
	public function staff(): string
	{
		$filter = function($row) {
			return is_null($row['deleted_at']) && $row['role'] === 'manageJobs';
		};

		return $this->index('Action Items', $filter);
	}

	/**
	 * Displays the active compiled rows
	 *
	 * @return string
	 */
	public function active(): string
	{
		$filter = function($row) {
			return is_null($row['deleted_at']) && ! is_null($row['stage_id']);
		};

		return $this->index('Active Jobs', $filter);
	}

	/**
	 * Displays compiled rows for archived jobs
	 *
	 * @return string
	 */
	public function archive(): string
	{
		$filter = function($row) {
			return is_null($row['deleted_at']) && is_null($row['stage_id']);
		};

		return $this->index('Archived Jobs', $filter, 'updated_at', false);
	}

	/**
	 * Displays all compiled rows (not deleted)
	 *
	 * @return string
	 */
	public function all(): string
	{
		$filter = function($row) {
			return is_null($row['deleted_at']);
		};

		return $this->index('All Jobs', $filter, 'updated_at', false);
	}

	/**
	 * Displays the compiled rows for deleted jobs
	 *
	 * @return string
	 */
	public function trash(): string
	{
		$filter = function($row) {
			return ! is_null($row['deleted_at']);
		};

		return $this->index('Deleted Jobs', $filter, 'deleted_at', false);
	}

	/**
	 * Displays the compiled rows.
	 *
	 * @param string $title
	 * @param Closure|null $filter
	 * @param string $sort
	 * @param bool $ascending
	 *
	 * @return string
	 */
	public function index(string $title = 'Jobs', Closure $filter = null, string $sort = 'stage_id', bool $ascending = true): string
	{
		return view('jobs/index', [
			'title' => $title,
			'rows'  => $this->model->getCompiledRows($filter, $sort, $ascending),
		]);
	}
}

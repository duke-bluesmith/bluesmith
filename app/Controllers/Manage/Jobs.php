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
	 * Display the compiled rows awaiting staff input
	 *
	 * @return string
	 */
	public function staff()
	{
		return view('jobs/index', [
			'title' => 'Action Items',
			'rows'  => $this->model->getCompiledRows(function($row) {
				return is_null($row['deleted_at']) && $row['role'] === 'manageJobs';
			}, 'stage_id')
		]);
	}

	/**
	 * Display the active compiled rows
	 *
	 * @return string
	 */
	public function active()
	{
		return view('jobs/index', [
			'title' => 'Active Jobs',
			'rows'  => $this->model->getCompiledRows(function($row) {
				return is_null($row['deleted_at']) && ! is_null($row['stage_id']);
			}, 'stage_id')
		]);
	}

	/**
	 * Display the active compiled rows
	 *
	 * @return string
	 */
	public function archive()
	{
		return view('jobs/index', [
			'title' => 'Archived Jobs',
			'rows'  => $this->model->getCompiledRows(function($row) {
				return is_null($row['deleted_at']) && is_null($row['stage_id']);
			}, 'stage_id')
		]);
	}

	/**
	 * Display all compiled rows (not deleted)
	 *
	 * @return string
	 */
	public function all()
	{
		return view('jobs/index', [
			'title' => 'All Jobs',
			'rows'  => $this->model->getCompiledRows(function($row) {
				return is_null($row['deleted_at']);
			}, 'updated_at', false),
		]);
	}

	/**
	 * Display the compiled rows for deleted jobs
	 *
	 * @return string
	 */
	public function trash()
	{
		return view('jobs/index', [
			'title' => 'Deleted Jobs',
			'rows'  => $this->model->getCompiledRows(function($row) {
				return ! is_null($row['deleted_at']);
			}, 'deleted_at')
		]);
	}
}

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
			'rows'  => $this->model->getCompiledRows(null, 'updated_at', false),
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
			'rows'  => $this->model->getCompiledRows(function($row) {
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
			'rows'  => $this->model->getCompiledRows(function($row) {
				return is_null($row['deleted_at']) && $row['role'] === 'manageJobs';
			}, 'stage_id')
		]);	
	}
}

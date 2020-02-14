<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\JobModel;

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
		$this->model = new JobModel();
	}

	// Display the Jobs browser UI
	public function index()
	{
		$data = [
			'jobs' => $this->model->findAll()
		];

		return view('jobs/index', $data);	
	}
}

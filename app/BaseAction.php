<?php namespace App;

use App\Entities\Job;
use App\Models\JobModel;
use Config\Workflows;
use Tatter\Workflows\BaseAction as ModuleBaseAction;

/**
 * BaseAction Abstract Class
 *
 * Provides common support methods for all
 * app Actions, and updated property types
 * for static analysis.
 */
abstract class BaseAction extends ModuleBaseAction
{
	/**
	 * @var Workflows
	 */
	public $config;

	/**
	 * @var Job
	 */
	public $job;

	/**
	 * @var JobModel
	 */
	public $jobs;

	/**
	 * Loads frequently-needed helpers
	 */
	public function __construct()
	{
		parent::__construct();

		helper(['currency', 'form', 'inflector', 'number']);
	}
}

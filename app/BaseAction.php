<?php namespace App;

use App\Entities\Job;
use App\Models\JobModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
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
	 *
	 * @param Job|null $job
	 * @param Workflows|null $config
	 * @param RequestInterface|null $request
	 * @param ResponseInterface|null $response
	 */
	public function __construct(Job $job = null, Workflows $config = null, RequestInterface $request = null, ResponseInterface $response = null)
	{
		parent::__construct($job, $config, $request, $response);

		helper(['currency', 'form', 'inflector', 'number']);
	}
}

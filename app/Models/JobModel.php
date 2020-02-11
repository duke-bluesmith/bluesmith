<?php namespace App\Models;

/**
 * Class JobModel
 *
 * Extension of the Workflows model to add Relations and Permits
 *
 */
class JobModel extends \Tatter\Workflows\Models\JobModel
{
	// Traits
	use \Tatter\Permits\Traits\PermitsTrait;
	use \Tatter\Relations\Traits\ModelTrait;

	protected $with          = ['options'];
	protected $returnType    = 'App\Entities\Job';
	protected $allowedFields = ['name', 'summary', 'workflow_id', 'stage_id', 'material_id'];

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
}

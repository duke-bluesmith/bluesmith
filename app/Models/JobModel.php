<?php namespace App\Models;

use App\Entities\Job;
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
			'job_id'  => (int) $jobId,
			'user_id' => (int) $userId,
		]);
	}
}

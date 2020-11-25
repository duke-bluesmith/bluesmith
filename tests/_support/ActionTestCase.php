<?php namespace Tests\Support;

use CodeIgniter\Test\FeatureResponse;
use Myth\Auth\Authorization\PermissionModel;
use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\Entities\Job;
use Tatter\Workflows\Entities\Stage;
use Tatter\Workflows\Entities\User;
use Tatter\Workflows\Entities\Workflow;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\StageModel;
use Tatter\Workflows\Models\WorkflowModel;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Fakers\JobFaker;

/**
 * Action Test Case
 *
 * Support class for testing Actions.
 */
abstract class ActionTestCase extends FeatureTestCase
{
	/**
	 * @var Action
	 */
	protected $action;

	/**
	 * @var Job
	 */
	protected $job;

	/**
	 * @var Stage
	 */
	protected $stage;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * @var Workflow
	 */
	protected $workflow;

	/**
	 * @var string
	 */
	protected $route;

	protected function setUp(): void
	{
		parent::setUp();

		$this->workflow = model(WorkflowModel::class)->where('name', 'Default Workflow')->first();
		$this->action   = model(ActionModel::class)->where('uid', $this->actionUid)->first();
		$this->stage    = model(StageModel::class)->where('action_id', $this->action->id)->where('workflow_id', $this->workflow->id)->first();

		// Create a random Job using the Default Workflow at the target Stage
		$this->job = fake(JobFaker::class, [
			'workflow_id' => $this->workflow->id,
			'stage_id'    => $this->stage->id,
		]);

		// Log in a User to be the Job owner
		$this->user = $this->createAuthUser();
		model(JobFaker::class)->addUserToJob($this->user->id, $this->job->id);

		// Grant the User manageJobs permission to access all Actions
		$permission = model(PermissionModel::class)->where(['name' => 'manageJobs'])->first();
		model(PermissionModel::class)->addPermissionToUser($permission['id'], $this->user->id);

		$this->route = $this->action->getRoute($this->job->id);
	}
}

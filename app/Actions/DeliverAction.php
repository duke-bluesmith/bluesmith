<?php namespace App\Actions;

use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\BaseAction;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class DeliverAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Complete',
		'name'     => 'Deliver',
		'uid'      => 'deliver',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-truck',
		'summary'  => 'Staff delivers objects to client',
	];
	
	public function get()
	{
		helper(['form', 'inflector']);

		return view('actions/deliver', [
			'job' => $this->job,
		]);
	}
	
	public function post()
	{
		$data = service('request')->getPost();

		// End the action
		return true;
	}
	
	public function put()
	{

	}
	
	// run when a job progresses forward through the workflow
	public function up()
	{
	
	}
	
	// run when job regresses back through the workflow
	public function down()
	{

	}
}

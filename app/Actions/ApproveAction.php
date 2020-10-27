<?php namespace App\Actions;

use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\BaseAction;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class ApproveAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Assess',
		'name'     => 'Approve',
		'uid'      => 'approve',
		'role'     => 'user',
		'icon'     => 'fas fa-thumbs-up',
		'summary'  => 'Client approves the estimate',
	];
	
	public function get()
	{

	}
	
	public function post()
	{

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

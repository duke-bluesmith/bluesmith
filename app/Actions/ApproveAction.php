<?php namespace App\Actions;

use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\Interfaces\ActionInterface;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class ApproveAction implements ActionInterface
{
	use \Tatter\Workflows\Traits\ActionsTrait;
	
	public $definition = [
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

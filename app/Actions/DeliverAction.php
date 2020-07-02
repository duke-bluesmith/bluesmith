<?php namespace App\Actions;

use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\Interfaces\ActionInterface;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class DeliverAction implements ActionInterface
{
	use \Tatter\Workflows\Traits\ActionsTrait;
	
	public $definition = [
		'category' => 'Compelte',
		'name'     => 'Deliver',
		'uid'      => 'deliver',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-truck',
		'summary'  => 'Staff delivers objects to client',
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

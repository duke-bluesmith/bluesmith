<?php namespace App\Actions;

use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\BaseAction;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class PrintAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	protected $attributes = [
		'category' => 'Process',
		'name'     => 'Print',
		'uid'      => 'print',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-cubes',
		'summary'  => 'Staff prints objects',
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

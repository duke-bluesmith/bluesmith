<?php namespace App\Tasks;

use App\Models\UserModel;
use Tatter\Workflows\Entities\Task;
use Tatter\Workflows\Interfaces\TaskInterface;
use Tatter\Workflows\Models\TaskModel;
use Tatter\Workflows\Models\WorkflowModel;

class AssignTask implements TaskInterface
{
	use \Tatter\Workflows\Traits\TasksTrait;

	public function __construct()
	{
		helper('alerts');
	}
	
	public $definition = [
		'category' => 'Define',
		'name'     => 'Assign Clients',
		'uid'      => 'clients',
		'icon'     => 'fas fa-user-friends',
		'summary'  => 'Client includes other clients',
	];
	
	public function get()
	{
		helper('form');

		$data = [
			'job' => $this->job,
		];
		return view('tasks/clients', $data);
	}
	
	public function post()
	{

	}
	
	public function put()
	{
		// All we care about is a valid email address
		$email = $this->request->getPost('email');
		$validation = service('validation');

		// Check for a legit email
		if (! $validation->check($email, 'valid_email'))
		{
			alert('warning', implode('. ', $validation->getErrors()));
			return redirect()->back();
		}

		// Try to match it to an existing user
		$users = new UserModel();
		
		// A match! Try to add the user
		if ($user = $users->where('email', $email)->first())
		{
			// Check for dupes
			if ($this->job->hasUser($user->id))
			{
				alert('warning', lang('Tasks.alreadyClient'));
			}
			elseif ($this->job->addUser($user->id))
			{
				alert('success', lang('Tasks.addClientSuccess', [$user->firstname]));
			}
			else
			{
				alert('error', lang('Tasks.addClientFail'));
			}
		}

		// New email - send an invitation
		else
		{
			// WIP
		}

		return redirect()->back();		
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

<?php namespace App\Actions;

use App\Entities\Job;
use App\Models\UserModel;
use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\BaseAction;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class AssignAction extends BaseAction
{
	/**
	 * @var Job
	 */
	public $job;

	/**
	 * @var array<string> Implemented by child class
	 */
	public $definition = [
		'category' => 'Define',
		'name'     => 'Assign Clients',
		'uid'      => 'clients',
		'role'     => 'user',
		'icon'     => 'fas fa-user-friends',
		'summary'  => 'Client includes other clients',
	];

	public function __construct()
	{
		helper('alerts');
	}

	// Display the form
	public function get()
	{
		// The first time through add the current user
		if (empty($this->job->users))
		{
			helper('auth');
			$this->job->addUser(user_id());
		}

		helper('form');

		$data = [
			'job' => $this->job,
		];
		return view('actions/clients', $data);
	}
	
	// Validate and continue
	public function post()
	{
		if (empty($this->job->users))
		{
			alert('warning', lang('Actions.needClients'));
			return redirect()->back();		
		}

		return true;
	}

	// Take an email address and add a user or send them an invite
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
				alert('warning', lang('Actions.alreadyClient'));
			}
			elseif ($this->job->addUser($user->id))
			{
				alert('success', lang('Actions.addClientSuccess', [$user->firstname]));
			}
			else
			{
				alert('error', lang('Actions.addClientFail'));
			}
		}

		// Email address not found - send an invitation
		else
		{
			if ($this->job->invite($email))
			{
				alert('success', lang('Actions.inviteSuccess', [$email]));
			}
			else
			{
				alert('error', lang('Actions.inviteFail'));
			}
		}

		return redirect()->back();		
	}

	// Remove a user or an invitation
	public function delete()
	{
		if ($userId = $this->request->getPost('user_id'))
		{
		
		}
		elseif ($inviteId = $this->request->getPost('invite_id'))
		{
		
		}
		else
		{
			alert('error', lang('Actions.removeClientFail'));
			return redirect()->back();
		}
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

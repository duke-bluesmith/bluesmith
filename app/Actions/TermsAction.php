<?php namespace App\Actions;

use App\Models\AcceptModel;
use App\Models\PageModel;
use App\Models\TermModel;
use Tatter\Workflows\BaseAction;

class TermsAction extends BaseAction
{
	public $definition = [
		'category' => 'Define',
		'name'     => 'Terms',
		'uid'      => 'terms',
		'role'     => 'user',
		'icon'     => 'fas fa-actions',
		'summary'  => 'Client accepts terms of service',
	];
	
	public function get()
	{
		helper(['form']);
		$pages = new PageModel();
		
		$data = [
			'job'   => $this->job,
			'page'  => $pages->where('name', 'TOS')->first(),
		];

		return view('actions/terms', $data);
	}
	
	public function post()
	{
		$data = $this->request->getPost();
		
		if (empty($data['accept']))
		{
			alert('warning', lang('Actions.mustAccept'));
			return redirect()->back();		
		}
		
		// End the action
		return true;
	}
	
	// run when a job progresses forward through the workflow
	public function up()
	{
		$accepts = new AcceptModel();

		// If skipping is allowed we'll assume this is deliberate and auto-accept on their behalf
		$row = [
			'job_id'  => $this->job->id,
			'user_id' => user_id(),
		];

		// Check for an existing row
		if (! $accepts->where($row)->first())
		{
			// Create the record of acceptance
			return $accepts->insert($row);
		}

		return true;
	}
	
	// run when job regresses back through the workflow
	public function down()
	{
		// Remove all acceptance records
		$accepts = new AcceptModel();
		return $accepts->where('job_id',$this->job->id)->delete();
	}
}

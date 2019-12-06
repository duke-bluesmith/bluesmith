<?php namespace App\Tasks;

use App\Models\PageModel;
use App\Models\TermModel;
use Tatter\Workflows\Interfaces\TaskInterface;

class TermsTask implements TaskInterface
{
	use \Tatter\Workflows\Traits\TasksTrait;
	
	public $definition = [
		'category' => 'Define',
		'name'     => 'Terms',
		'uid'      => 'terms',
		'icon'     => 'fas fa-tasks',
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

		return view('tasks/terms', $data);
	}
	
	public function post()
	{
		$data = $this->request->getPost();
		
		if (empty($data['accept']))
		{
			alert('warning', lang('Tasks.mustAccept'));
			return redirect()->back();		
		}
		
		// End the task
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

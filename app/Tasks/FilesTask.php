<?php namespace App\Tasks;

use Tatter\Workflows\Entities\Task;
use Tatter\Workflows\Interfaces\TaskInterface;
use Tatter\Workflows\Models\TaskModel;
use Tatter\Workflows\Models\WorkflowModel;

class FilesTask implements TaskInterface
{
	use \Tatter\Workflows\Traits\TasksTrait;
	
	public $definition = [
		'category' => 'Define',
		'name'     => 'Files',
		'uid'      => 'files',
		'icon'     => 'fas fa-file-alt',
		'summary'  => 'Client selects or uploads files',
	];
	
	public function get()
	{
		$data = [
			'config'  => $this->config,
			'job'     => $this->job,
			'message' => session('message')
		];
		return view('tasks/files', $data);
	}
	
	public function post()
	{
		$this->job->word = $this->request->getPost('word');
		$this->jobs->save($this->job);
		return redirect()->to($this->route())->with('message', "Your word has been set to '{$this->job->word}'");
	}
	
	public function put()
	{
		return true;
	}
	
	// run when a job progresses forward through the workflow
	public function up()
	{
	
	}
	
	// run when job regresses back through the workflow
	public function down()
	{
		$this->jobs->update($this->job->id, ['score' => null]);
	}
}

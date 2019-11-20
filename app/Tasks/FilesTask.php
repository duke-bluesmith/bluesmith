<?php namespace App\Tasks;

use Tatter\Files\Models\FileModel;
use Tatter\Workflows\Interfaces\TaskInterface;

class FilesTask implements TaskInterface
{
	use \Tatter\Workflows\Traits\TasksTrait;

	public function __construct()
	{		
		// Preload the Files model and helper
		$this->files = new FileModel();
		helper(['auth', 'files']);
	}
	
	public $definition = [
		'category' => 'Define',
		'name'     => 'Files',
		'uid'      => 'files',
		'icon'     => 'fas fa-file-alt',
		'summary'  => 'Client selects or uploads files',
	];
	
	public function get()
	{
		helper('form');

		$data = [
			'job'      => $this->job,
			'files'    => $this->files->getForUser(user_id()),
		];
		return view('tasks/files', $data);
	}
	
	public function post()
	{
		$data = $this->request->getPost();

		// Harvest file IDs
		$action = '';
		$fileIds = [];
		foreach ($data as $key => $value)
		{
			if (is_numeric($value) && strpos($key, 'file') === 0)
			{
				$fileIds[] = $value;
			}
		}
		
		// Filter by user's files
		$fileIds = array_intersect($fileIds, array_column($this->files->getForUser(user_id()), 'id'));
		
		if (! empty($fileIds))
		{
			$this->job->setFiles($fileIds);
		}
		else
		{
			$this->job->setFiles([]);
		}

		// End the task
		return true;
	}
	
	// Run when a job progresses forward through the workflow
	public function up()
	{
	
	}
	
	// Run when job regresses back through the workflow
	public function down()
	{

	}
}

<?php namespace App\Actions;

use Tatter\Files\Models\FileModel;
use Tatter\Workflows\BaseAction;

class FilesAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	protected $attributes = [
		'category' => 'Define',
		'name'     => 'Files',
		'uid'      => 'files',
		'role'     => 'user',
		'icon'     => 'fas fa-file-alt',
		'summary'  => 'Client selects or uploads files',
	];

	/**
	 * @var FileModel
	 */
	protected $files;

	public function __construct()
	{		
		// Preload the Files model and helper
		$this->files = new FileModel();
		helper('files');
	}
	
	public function get()
	{
		helper('form');

		$data = [
			'job'      => $this->job,
			'files'    => $this->files->getForUser(user_id()),
			'selected' => array_column($this->job->files ?? [], 'id'),
		];
		return view('actions/files', $data);
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

		// End the action
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

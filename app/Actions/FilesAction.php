<?php namespace App\Actions;

use App\BaseAction;
use App\Entities\Job;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Workflows;
use Tatter\Files\Models\FileModel;

class FilesAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Define',
		'name'     => 'Files',
		'uid'      => 'files',
		'role'     => '',
		'icon'     => 'fas fa-file-alt',
		'summary'  => 'Client selects or uploads files',
	];

	/**
	 * @var FileModel
	 */
	protected $files;

	/**
	 * Preloads the Files model and helper
	 *
	 * @param Job|null $job
	 * @param Workflows|null $config
	 * @param RequestInterface|null $request
	 * @param ResponseInterface|null $response
	 */
	public function __construct(Job $job = null, Workflows $config = null, RequestInterface $request = null, ResponseInterface $response = null)
	{
		parent::__construct($job, $config, $request, $response);

		$this->files = new FileModel();
		helper('files');
	}

	/**
	 * Displays the file selection form.
	 *
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface
	{
		return $this->response->setBody(view('actions/files', [
			'job'      => $this->job,
			'files'    => $this->files->getForUser(user_id()),
			'selected' => array_column($this->job->files ?? [], 'id'),
		]));
	}

	/**
	 * Processes file selection.
	 *
	 * @return ResponseInterface|null
	 */
	public function post(): ?ResponseInterface
	{
		// Harvest file IDs
		$action  = '';
		$fileIds = [];

		foreach (service('request')->getPost() as $key => $value)
		{
			if (is_numeric($value) && strpos($key, 'file') === 0)
			{
				$fileIds[] = $value;
			}
		}

		// Filter by user's files
		$fileIds = array_intersect($fileIds, array_column($this->files->getForUser(user_id()), 'id'));

		if ($fileIds !== [])
		{
			$this->job->setFiles($fileIds);
		}
		else
		{
			$this->job->setFiles([]);
		}

		// End the action
		return null;
	}
}

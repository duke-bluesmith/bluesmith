<?php

namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\ResponseInterface;
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
        'header'   => 'Select Files',
        'button'   => 'Files Selected',
    ];

    /**
     * @var FileModel
     */
    protected $files;

    /**
     * Preloads the Files model and helper
     */
    public function initialize()
    {
        parent::initialize();

        $this->files = new FileModel();
        helper('files');
    }

    /**
     * Displays the file selection form.
     */
    public function get(): ResponseInterface
    {
        return $this->render('actions/files', [
            'files'    => $this->files->getForUser(user_id()),
            'selected' => array_column($this->job->files ?? [], 'id'),
        ]);
    }

    /**
     * Processes file selection.
     */
    public function post(): ?ResponseInterface
    {
        // Harvest file IDs
        $action  = '';
        $fileIds = [];

        foreach (service('request')->getPost() as $key => $value) {
            if (is_numeric($value) && strpos($key, 'file') === 0) {
                $fileIds[] = $value;
            }
        }

        // Filter by user's files
        $fileIds = array_intersect($fileIds, array_column($this->files->getForUser(user_id()), 'id'));

        if ($fileIds !== []) {
            $this->job->setFiles($fileIds);
        } else {
            $this->job->setFiles([]);
        }

        // End the action
        return null;
    }
}

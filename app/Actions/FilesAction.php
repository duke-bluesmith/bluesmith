<?php

namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\RedirectResponse;
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
        // Activate this Job for imminent file uploads
        session()->set('file_job_upload', $this->job->id);

        return $this->render('actions/files', [
            'files'    => $this->job->files ?? [],
            'selected' => array_column($this->job->files ?? [], 'id'),
        ]);
    }

    /**
     * Removes a single File.
     */
    public function delete(): ?ResponseInterface
    {
        if ($fileId = service('request')->getPost('file_id')) {
            $this->job->removeFile($fileId);
            alert('warning', 'File removed.');
        }

        return redirect()->back();
    }

    /**
     * Finishes file selection.
     */
    public function post(): ?ResponseInterface
    {
        // Need either files or the "later" checkbox
        if (empty($this->job->files) && empty($this->request->getPost('accept'))) {
            return redirect()->back()->with('error', 'Please upload files or indicate your intention to provide them later.');
        }

        // Deactivate the Job for uploads
        session()->remove('file_job_upload');

        // End the action
        return null;
    }
}

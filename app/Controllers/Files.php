<?php namespace App\Controllers;

use App\Models\FileModel;

class Files extends BaseController
{
	public function __construct()
	{		
		// Preload the model
		$this->model = new FileModel();
	}
	
	// Displays files for the current user
	public function index()
	{
		$files = $this->model->getForUser(user_id());
		return view('files/index', ['files' => $files]);
	}

	public function create()
	{
		$files = $this->request->getFiles();
		$post = $this->request->getPost();
		
		if ($chunkIndex = $this->request->getPost('chunkIndex')):
			$uuid = $this->request->getPost('uuid');
			$totalChunks = $this->request->getPost('totalChunks');
		endif;
	}
}

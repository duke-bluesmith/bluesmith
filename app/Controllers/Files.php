<?php namespace App\Controllers;

use App\Models\FileModel;
use CodeIgniter\Files\File;

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
	
	// Receives uploads from Dropzone
	public function upload()
	{
		// Verify upload succeeded
		$file = $this->request->getFile('file');
		if (empty($file))
			return $this->failure(400, 'No file supplied.');
		if (! $file->isValid())
			return ($file->getErrorString() . '(' . $file->getError() . ')');

		// Check for chunks
		if ($this->request->getPost('chunkIndex') !== null):
		
			// Gather chunk info
			$chunkIndex = $this->request->getPost('chunkIndex');
			$totalChunks = $this->request->getPost('totalChunks');
			$uuid = $this->request->getPost('uuid');
			
			// Check for chunk directory
			$dir = WRITEPATH . 'uploads/chunks/' . $uuid;
			if (! is_dir($dir)):
				mkdir($dir, 0775);
			endif;
			
			// Move the file
			$file->move($dir, $chunkIndex . '.' . $file->getExtension());
			
			// Check for more chunks
			if ($chunkIndex < $totalChunks-1):
				return;
			endif;
			
			// Save client name from last chunk
			$clientname = $file->getClientName();
			
			// Merge the chunks
			$path = $this->mergeChunks($dir);
			$file = new File($path);
			
			// Gather merged file data
			$row = [
				'name'       => $clientname,
				'filename'   => $file->getRandomName(),
				'clientname' => $clientname,
				'type'       => $file->getMimeType(),
				'size'       => $file->getSize(),
			];

		// No chunks, handle as a straight upload
		else:
			log_message('debug', 'New file upload: ' . $file->getClientName());

			// Gather file info
			$row = [
				'name'       => $file->getClientName(),
				'filename'   => $file->getRandomName(),
				'clientname' => $file->getClientName(),
				'type'       => $file->getMimeType(),
				'size'       => $file->getSize(),
			];
		endif;
		
		// Move the file
		$file->move(WRITEPATH . 'uploads/files', $row['filename']);
		chmod(WRITEPATH . 'uploads/files/' . $row['filename'], 0664); //WIP

		// Record in the database
		$fileId = $this->model->insert($row);
		
		// Associate with the current user
		$this->model->addToUser($fileId, user_id());
	}
	
	protected function failure($errorCode, $errorMessage)
	{
		log_message('debug', $errorMessage);
		
		if ($this->request->isAJAX()):
			$response = ['error' => $errorMessage];
			$this->response->setStatusCode($errorCode);
			return $this->response->setJSON($response);
		else:
			alert('error', $errorMessage);
			return redirect()->back();
		endif;
	}
	
	// Merges all chunks in a target directory into a single file, returns the file path
	protected function mergeChunks($dir)
	{
		helper('filesystem');
		helper('text');
		
		// Get chunks from target directory
		$chunks = get_filenames($dir, true);
		if (empty($chunks))
			throw new RuntimeException('No valid files found for chunk merge.');
		
		// Create the temp file
		$tmpfile = tempnam(sys_get_temp_dir(), random_string());
		log_message('debug', 'Merging ' . count($chunks) . ' chunks to ' . $tmpfile);

		// Open temp file for writing
		$output = @fopen($tmpfile, 'ab');
		if (! $output)
			throw new RuntimeException('Unable to create file for merging.');
		
		// Write each chunk to the temp file
		foreach ($chunks as $file):
			$input = @fopen($file, 'rb');
			if (! $input)
				throw new RuntimeException("Unable to open '{$file}' for merging");
			
			// Buffered merge of chunk
			while ($buffer = fread($input, 4096))
				fwrite($output, $buffer);
			
			fclose($input);
		endforeach;
		
		// close output handle
		fclose($output);

		return $tmpfile;
	}
}

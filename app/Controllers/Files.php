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
		var_dump($files);
		log_message('debug', 'New file: ' . print_r($files, true));
	}

	public function merge($uuid = null)
	{
		$files = $this->request->getFiles();
		var_dump($files);
		log_message('debug', 'Merge file: ' . $uuid . print_r($files, true));
		log_message('debug', 'Merge post: ' . print_r($_POST, true));
	}

	public function fail()
	{
		$files = $this->request->getFiles();
		var_dump($files);
		log_message('debug', 'Fail file: ' . print_r($files, true));
		log_message('debug', 'Fail post: ' . print_r($_POST, true));
	}
}
/*
DEBUG - 2019-07-23 12:16:21 --> New file: Array
(
    [file] => CodeIgniter\HTTP\Files\UploadedFile Object
        (
            [path:protected] => /tmp/phppA2Qcg
            [originalName:protected] => RaRaPizzaWAYshot.jpg
            [name:protected] => RaRaPizzaWAYshot.jpg
            [originalMimeType:protected] => application/octet-stream
            [error:protected] => 0
            [hasMoved:protected] => 
            [size:protected] => 1000000
            [pathName:SplFileInfo:private] => /tmp/phppA2Qcg
            [fileName:SplFileInfo:private] => phppA2Qcg
        )

)

DEBUG - 2019-07-23 12:16:21 --> New file: Array
(
    [file] => CodeIgniter\HTTP\Files\UploadedFile Object
        (
            [path:protected] => /tmp/phpE6Kim1
            [originalName:protected] => MarchforBrokenDreams2.jpg
            [name:protected] => MarchforBrokenDreams2.jpg
            [originalMimeType:protected] => image/jpeg
            [error:protected] => 0
            [hasMoved:protected] => 
            [size:protected] => 239809
            [pathName:SplFileInfo:private] => /tmp/phpE6Kim1
            [fileName:SplFileInfo:private] => phpE6Kim1
        )

)

DEBUG - 2019-07-23 12:16:21 --> New file: Array
(
    [file] => CodeIgniter\HTTP\Files\UploadedFile Object
        (
            [path:protected] => /tmp/phpAdtalE
            [originalName:protected] => RaRaPizzaWAYshot.jpg
            [name:protected] => RaRaPizzaWAYshot.jpg
            [originalMimeType:protected] => application/octet-stream
            [error:protected] => 0
            [hasMoved:protected] => 
            [size:protected] => 674659
            [pathName:SplFileInfo:private] => /tmp/phpAdtalE
            [fileName:SplFileInfo:private] => phpAdtalE
        )

)

DEBUG - 2019-07-23 12:16:21 --> Merge file: 50678abf-6b0a-45d3-87b7-265d0fc2e657Array
(
)

DEBUG - 2019-07-23 12:16:21 --> Merge post: Array
(
)
*/

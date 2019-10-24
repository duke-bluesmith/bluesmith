<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Workflows extends \Tatter\Workflows\Config\Workflows
{
	// The model to use for jobs
	public $jobModel = 'App\Models\JobModel';

	// Layouts to use for jobs and administration
	public $layouts = [
		'public' => 'layouts/public',
		'manage' => 'layouts/manage',
	];
	
	// Views to display for each function
	public $views = [
		'messages'  => 'Tatter\Workflows\Views\messages',
		'complete'  => 'Tatter\Workflows\Views\complete',
		'deleted'   => 'Tatter\Workflows\Views\deleted',
	];
}

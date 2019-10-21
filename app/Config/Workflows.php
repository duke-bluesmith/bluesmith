<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Workflows extends \Tatter\Workflows\Config\Workflows
{
	// The model to use for jobs
	public $jobModel = 'Tatter\Workflows\Models\JobModel';
	
	// Layout to use for views
	public $layout = 'layouts/manage';
	
	// Views to display for each function
	public $views = [
		'messages'  => 'Tatter\Workflows\Views\messages',
		'complete'  => 'Tatter\Workflows\Views\complete',
		'deleted'   => 'Tatter\Workflows\Views\deleted',
	];
}

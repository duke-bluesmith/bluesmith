<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Workflows extends Tatter\Workflows\Config\Workflows
{
	// the model to use for jobs
	public $jobModel = 'App\Models\JobModel';
	
	// views to display for each function
	public $views = [
		'header'    => 'Tatter\Workflows\Views\templates\header',
		'footer'    => 'Tatter\Workflows\Views\templates\footer',
		'messages'  => 'Tatter\Workflows\Views\messages',
		'complete'  => 'Tatter\Workflows\Views\complete',
		'deleted'   => 'Tatter\Workflows\Views\deleted',
	];
}

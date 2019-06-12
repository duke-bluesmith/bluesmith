<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Assets extends \Tatter\Assets\Config\Assets
{
	// additional assets to load per route - no leading/trailing slashes
	public $routes = [
		'' => [
			'jquery/jquery.min.js',
			'bootstrap/bootstrap.min.css',
			'bootstrap/bootstrap.bundle.min.js',
			'font-awesome/css/all.min.css',
		],
		'files/upload' => [
			'dropzone/dropzone.min.css',
			'dropzone/dropzone.min.js',
		],
	];
}

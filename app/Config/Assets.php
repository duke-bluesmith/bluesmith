<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Assets extends \Tatter\Assets\Config\Assets
{
	// additional assets to load per route - no leading/trailing slashes
	public $routes = [
		'' => [
			'vendor/jquery/jquery.min.js',
			'vendor/bootstrap/bootstrap.min.css',
			'vendor/bootstrap/bootstrap.bundle.min.js',
			'vendor/font-awesome/css/all.min.css',
		],
		'files/upload' => [
			'vendor/dropzone/dropzone.min.css',
			'vendor/dropzone/dropzone.min.js',
		],
		'cms' => [
			'vendor/tinymce/tinymce.min.js',
		]
	];
}

<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Assets extends \Tatter\Assets\Config\Assets
{
	// Additional assets to load per route - no leading/trailing slashes
	public $routes = [
		'' => [
			'vendor/bootstrap/bootstrap.min.css',
			'vendor/bootstrap/bootstrap.bundle.min.js',
			'vendor/font-awesome/css/all.min.css',
		],
		'files' => [
			'vendor/dropzone/dropzone.min.css',
			'vendor/dropzone/dropzone.min.js',
		],
		
		// Admin dashboard
		'manage' => [
			'vendor/forms',
			'vendor/chartjs/Chart.min.css',
			'vendor/chartjs/Chart.bundle.min.js',
			'vendor/datatables/css/dataTables.bootstrap4.min.css',
			'vendor/datatables/css/buttons.bootstrap4.min.css',
			'vendor/datatables/js/jquery.dataTables.min.js',
			'vendor/datatables/js/dataTables.bootstrap4.min.js',
			'vendor/datatables/js/dataTables.buttons.min.js',
			'vendor/datatables/js/buttons.html5.min.js',
			'vendor/datatables/js/buttons.print.min.js',
			'vendor/sbadmin2/sb-admin-2.min.css',
			'vendor/sbadmin2/sb-admin-2.min.js',
		],
		
		'workflows' => [
			'vendor/sbadmin2/sb-admin-2.min.css',
			'vendor/sbadmin2/sb-admin-2.min.js',
			'vendor/sortablejs/Sortable.min.js',
		],
		
		'tasks' => [
			'vendor/sbadmin2/sb-admin-2.min.css',
			'vendor/sbadmin2/sb-admin-2.min.js',
			'vendor/sortablejs/Sortable.min.js',
		],
		
		'jobs' => [
			'vendor/sbadmin2/sb-admin-2.min.css',
			'vendor/sbadmin2/sb-admin-2.min.js',
			'vendor/sortablejs/Sortable.min.js',
		],
	];
}

<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\MethodModel;

class Methods extends BaseController
{
	// Manage print methods
	public function index()
	{
		$methods = new MethodModel();

		$data = [
			'methods' => $methods->with('materials')->findAll()
		];

		return view('methods/index', $data);	
	}
	
	// Display the form for a new method
	public function new($methodId)
	{
		return view('methods/new', $data);	
	}
}

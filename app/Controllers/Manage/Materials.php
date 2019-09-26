<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\MethodModel;

class Materials extends BaseController
{
	// Manage print materials
	public function index()
	{
		$methods = new MethodModel();

		$data = [
			'methods' => $methods->findAll()
		];

		return view('manage/materials/index', $data);	
	}
	
	// Display the form for a new material
	public function new($methodId)
	{
		$methods = new MethodModel();

		$data = [
			'methods' => $methods->findAll()
		];

		return view('manage/materials/new', $data);	
	}
}

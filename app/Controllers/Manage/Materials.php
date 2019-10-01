<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\MethodModel;

class Materials extends BaseController
{
	// Manage print materials
	public function index()
	{
		$materials = new MaterialModel();

		$data = [
			'materials' => $materials->findAll()
		];

		return view('materials/index', $data);	
	}
	
	// Print materials for one method
	public function method($methodId)
	{
		$methods = new MethodModel();
		$method  = $methods->find($methodId);
		$materials = new MaterialModel();

		$data = [
			'method'    => $method,
			'materials' => $materials->where('method_id', $method->id)->findAll()
		];

		return view('materials/method', $data);	
	}
	
	// Display the form for a new material
	public function new($methodId)
	{
		$methods = new MethodModel();

		$data = [
			'methods' => $methods->findAll()
		];

		return view('materials/new', $data);	
	}
}

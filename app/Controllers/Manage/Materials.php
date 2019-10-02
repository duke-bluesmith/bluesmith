<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\MethodModel;

class Materials extends BaseController
{
	// List all print materials
	public function index()
	{
		$materials = new MaterialModel();

		$data = [
			'materials' => $materials->findAll()
		];

		return view('materials/index', $data);	
	}
	
	// List materials for one method
	public function method($methodId)
	{
		$methods = new MethodModel();

		$data = [
			'method' => $methods->find($methodId)
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

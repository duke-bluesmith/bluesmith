<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\MethodModel;

class Methods extends BaseController
{
	/**
	 * Displays the form to manage print Methods
	 *
	 * @return string
	 */
	public function index(): string
	{
		$methods = new MethodModel();

		return view('methods/index', [
			'methods' => $methods->with('materials')->findAll()
		]);
	}
	
	/**
	 * Displays the form for a new Method
	 *
	 * @param string $methodId
	 *
	 * @return string
	 */
	public function new(string $methodId): string
	{
		return view('methods/new');	
	}
}

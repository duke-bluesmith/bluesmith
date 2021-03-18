<?php namespace App\Controllers\Api;

use Tatter\Forms\Controllers\ResourceController;
use App\Models\MethodModel;

class Materials extends ResourceController
{
	protected $modelName = 'App\Models\MaterialModel';
	
	// Intercept filter requests
	public function index()
	{
		if ($methodId = $this->request->getGet('method_id', FILTER_SANITIZE_NUMBER_INT))
		{
			$this->model->where('method_id', $methodId);
		}
		
		return parent::index();
	}
}

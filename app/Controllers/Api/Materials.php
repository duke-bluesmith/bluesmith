<?php

namespace App\Controllers\Api;

use App\Models\MaterialModel;
use Tatter\Forms\Controllers\ResourceController;

class Materials extends ResourceController
{
	protected $modelName = MaterialModel::class;

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

<?php namespace App\Controllers\Api;

use App\Models\MethodModel;
use Tatter\Forms\Controllers\ResourceController;

class Methods extends ResourceController
{
	protected $modelName = MethodModel::class;
}

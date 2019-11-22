<?php namespace App\Models;

class MethodModel extends BaseModel
{
	protected $table         = 'methods';
	protected $returnType    = 'App\Entities\Method';
	protected $allowedFields = ['name', 'summary', 'description', 'sortorder'];
}

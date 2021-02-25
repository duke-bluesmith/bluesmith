<?php namespace App\Models;

class MaterialModel extends BaseModel
{
	protected $table         = 'materials';
	protected $with          = ['methods'];
	protected $returnType    = 'App\Entities\Material';
	protected $allowedFields = ['name', 'summary', 'description', 'sortorder', 'method_id'];

	protected $validationRules = [
		'name'      => 'required',
		'method_id' => 'required|is_natural_no_zero',
	];
}

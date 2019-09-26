<?php namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends BaseModel
{
	protected $table      = 'materials';
	protected $primaryKey = 'id';

	protected $returnType = 'App\Entities\Material';
	protected $useSoftDeletes = true;

	protected $allowedFields = [
		'name', 'summary', 'description', 'sortorder', 'method_id',
		'created_at', 'updated_at', 'deleted_at',
	];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	
	protected $with = ['methods'];
}

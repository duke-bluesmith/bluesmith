<?php namespace App\Models;

use CodeIgniter\Model;

class MethodModel extends BaseModel
{
	protected $table      = 'methods';
	protected $primaryKey = 'id';

	protected $returnType = 'App\Entities\Method';
	protected $useSoftDeletes = true;

	protected $allowedFields = [
		'name', 'summary', 'description', 'sortorder',
		'created_at', 'updated_at', 'deleted_at',
	];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	
	// Store of pre-fetched relatives
	public static $materials = [];

	// Pre-loads all materials into the model's static property
	// If a method ID was supplied then return its materials
	public function fetchMaterials($methodId = null)
	{
		// Check if already loaded
		if (empty(self::$materials))
		{
			// Get all the materials from the model
			$materials = new MaterialModel();
			foreach ($materials->findAll() as $material)
			{
				// Index by material ID
				self::$materials[$material->method_id] = [$material];
			}
		}
		
		if ($methodId)
			return self::$materials[$methodId] ?? [];
		return self::$materials;
	}
}

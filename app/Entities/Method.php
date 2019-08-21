<?php namespace App\Entities;

use App\Models\MethodModel;
use CodeIgniter\Entity;

class Method extends Entity
{
	protected $dates = ['created_at', 'updated_at', 'expired_at'];
		
	// Returns materials supported by this method
	public function getMaterials()
	{
		$methods = new MethodModel();
		return $methods->fetchMaterials($this->attributes['id']);
	}
}

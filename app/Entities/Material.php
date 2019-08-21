<?php namespace App\Entities;

use App\Models\MaterialModel;
use CodeIgniter\Entity;

class Material extends Entity
{
	protected $dates = ['created_at', 'updated_at', 'expired_at'];
		
	// Returns the method for this material
	public function getMethod()
	{
		$materials = new MaterialModel();
		$materials->fetchMethods();
		return $materials->materials[$this->attributes['id']] ?? [];
	}
}

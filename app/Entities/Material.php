<?php namespace App\Entities;

use App\Models\MaterialModel;
use CodeIgniter\Entity;

class Material extends Entity
{
	protected $dates = ['created_at', 'updated_at', 'expired_at'];
}

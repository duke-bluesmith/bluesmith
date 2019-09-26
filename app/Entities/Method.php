<?php namespace App\Entities;

use App\Models\MethodModel;
use CodeIgniter\Entity;

class Method extends Entity
{
	protected $dates = ['created_at', 'updated_at', 'expired_at'];
}

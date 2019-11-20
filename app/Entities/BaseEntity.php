<?php namespace App\Entities;

use CodeIgniter\Entity;

class BaseEntity extends Entity
{
	use \Tatter\Relations\Traits\EntityTrait;

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}

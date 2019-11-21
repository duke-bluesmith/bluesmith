<?php namespace App\Entities;

class User extends \Myth\Auth\Entities\User
{
	use \Tatter\Relations\Traits\EntityTrait;

	protected $table      = 'users';
	protected $primaryKey = 'id';
}

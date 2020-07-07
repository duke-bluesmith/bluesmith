<?php namespace App\Entities;

class User extends \Myth\Auth\Entities\User
{
	use \Tatter\Relations\Traits\EntityTrait;

	protected $table      = 'users';
	protected $primaryKey = 'id';

	/**
	 * Return a full name: "first last"
	 *
	 * @return string
	 */
	public function getName()
	{
		return trim(trim($this->attributes['firstname']) . ' ' . trim($this->attributes['lastname']));
	}
}

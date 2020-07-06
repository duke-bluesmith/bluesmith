<?php namespace Tests\Support\Fakers;

use App\Entities\User;
use App\Models\UserModel;
use Faker\Generator;

class UserFaker extends UserModel
{
	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return User
	 */
	public function fake(Generator &$faker): User
	{
		return new User([
			'email'     => $faker->email,
			'username'  => str_replace('.', ' ', $faker->userName), // Myth doesn't allow periods
			'firstname' => $faker->firstName,
			'lastname'  => $faker->lastName,
			'password'  => bin2hex(random_bytes(24)),
			'active'    => (bool) rand(0, 20),
		]);
	}
}

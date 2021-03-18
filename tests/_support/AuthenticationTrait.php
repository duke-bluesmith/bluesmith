<?php namespace Tests\Support;

use App\Entities\User;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Test\AuthTestTrait;
use RuntimeException;

/**
 * Authentication Test Trait
 *
 * Provides support functions for any
 * tests needing users and authentication.
 */
trait AuthenticationTrait
{
	use \Myth\Auth\Test\AuthTestTrait;

	/**
	 * @var User
	 */
	protected $user;

	/**
	 * Creates a fake User and logs it in.
	 */
	protected function setUpAuthenticationTrait(): void
	{
		$this->user = $this->createAuthUser(true);
	}

	/**
	 * Append the methods here since no
	 * other tests use the constructor.
	 */
	protected function tearDownAuthenticationTrait(): void
	{
		$this->resetAuthServices();
	}

	/**
	 * Adds a permission to the given User.
	 *
	 * @param string $name
	 * @param User $user
	 *
	 * @return void
	 */
	protected function addPermissionToUser(string $name, User $user): void
	{
		// Look up the permission
		if (! $permission = model(PermissionModel::class)->where(['name' => $name])->first())
		{
			throw new RuntimeException('Unable to locate that permission: ' . $name);
		}

		if (! model(PermissionModel::class)->addPermissionToUser($permission->id, $user->id))
		{
			throw new RuntimeException(implode('.', model(PermissionModel::class)->error()));
		}
	}
}

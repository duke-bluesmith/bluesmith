<?php namespace Tests\Support;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Test\Fabricator;
use Config\Services;
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
		/** @var User $user */
		$user       = $this->createAuthUser(true);
		$this->user = $user;
	}

    /**
     * Creates a new faked User, optionally logging them in.
     * Overrides Myth:Auth's version so we can use our own Faker.
     *
     * @param bool $login      Whether to log in the new User
     * @param array $overrides Overriding data for the Fabricator
     *
     * @return User
     * @throws RuntimeException Usually only if overriding data fails to validate
     */
	protected function createAuthUser(bool $login = true, array $overrides = []): User
	{
		$fabricator = new Fabricator(UserModel::class);

		// Set overriding data, if necessary
		if (! empty($overrides))
		{
			$fabricator->setOverrides($overrides);
		}

		/**
		 * @var User $user
		 */
		$user = $fabricator->make();
		$user->activate();

		if (! $userId = model(UserModel::class)->insert($user))
		{
			$error = implode(' ', model(UserModel::class)->errors());

			throw new RuntimeException('Unable to create user: ' . $error);
		}

		// Look the user up using Model Factory in case it is overridden in App
		$user = model(UserModel::class)->find($userId);

		if ($login)
		{
			$auth = service('authentication');
			$auth->login($user);
			Services::injectMock('authentication', $auth);
		}

		return $user;
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
	 * Defaults to $this->user.
	 *
	 * @param string $name
	 * @param User|null $user
	 *
	 * @return void
	 */
	protected function addPermissionToUser(string $name, User $user = null): void
	{
		$user = $user ?? $this->user;

		// Look up the permission
		if (! $permission = model(PermissionModel::class)->where(['name' => $name])->first())
		{
			throw new RuntimeException('Unable to locate that permission: ' . $name);
		}

		if (! model(PermissionModel::class)->addPermissionToUser($permission['id'], $user->id))
		{
			throw new RuntimeException(implode('.', model(PermissionModel::class)->error()));
		}
	}
}

<?php namespace Tests\Support;

use App\Entities\User;
use CodeIgniter\Test\CIDatabaseTestCase;
use Config\Services;
use Faker\Factory;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Authorization\PermissionModel;
use Tests\Support\Fakers\UserFaker;
use Tests\Support\Simulator;

class DatabaseTestCase extends CIDatabaseTestCase
{
	use \Myth\Auth\Test\AuthTestTrait;

	/**
	 * Faker instance for generating content.
	 *
	 * @var Faker\Factory
	 */
	protected static $faker;

	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;

	/**
	 * The namespace(s) to help us find the migration classes.
	 * Empty is equivalent to running `spark migrate -all`.
	 * Note that running "all" runs migrations in date order,
	 * but specifying namespaces runs them in namespace order (then date)
	 *
	 * @var string|array|null
	 */
    protected $namespace = null;

	/**
	 * The seed file(s) used for all tests within this test case.
	 * Should be fully-namespaced or relative to $basePath
	 *
	 * @var string|array
	 */
	protected $seed = 'App\Database\Seeds\InitialSeeder';

	//--------------------------------------------------------------------
	// Staging
	//--------------------------------------------------------------------

    /**
     * Initializes the one-time components.
     */
    public static function setUpBeforeClass(): void
    {
    	parent::setUpBeforeClass();

		self::$faker = Factory::create();
    }

    /**
     * Always reset the simulation between classes.
     */
    public static function tearDownAfterClass(): void
    {
    	Simulator::reset();
    }

	//--------------------------------------------------------------------
	// Simulation
	//--------------------------------------------------------------------

    /**
     * Initialize the simulation, if it has not been.
     */
	protected function simulateOnce()
	{
		// Initialize the simulation only once since it is costly.
		if (! Simulator::$initialized)
		{
			// Rerun database setUp as a refresh
			$tmpRefresh    = $this->refresh;
			$this->refresh = true;

			parent::setUp();

			$this->refresh = $tmpRefresh;

			Simulator::initialize();
		}
	}

	/**
	 * Create a User with the requested Permission.
	 *
	 * @param int|string|object $identifier  The target permission
	 */
	protected function createUserWithPermission($identifier): User
	{
		if (is_array($identifier))
		{
			$id = $identifier['id'];
		}
		elseif (is_object($identifier))
		{
			$id = $identifier->id;
		}
		elseif (is_numeric($identifier))
		{
			$id = (int) $identifier;
		}
		elseif (is_string($identifier))
		{
			$permission = model(PermissionModel::class)->where(['name' => $identifier])->first();
			$id = $permission['id'];
		}
		else
		{
			throw new \RuntimeException('Unable to determine type for $identifier');
		}

		$user = fake(UserFaker::class);
		model(PermissionModel::class)->addPermissionToUser($id, $user->id);

		return $user;
	}

	/**
	 * Create a User part of the requested Group.
	 *
	 * @param int|string|object $identifier  The target group
	 */
	public function createUserInGroup($identifier): User
	{
		if (is_array($identifier))
		{
			$id = $identifier['id'];
		}
		elseif (is_object($identifier))
		{
			$id = $identifier->id;
		}
		elseif (is_numeric($identifier))
		{
			$id = (int) $identifier;
		}
		elseif (is_string($identifier))
		{
			$group = model(GroupModel::class)->where(['name' => $identifier])->first();
			$id = $group->id;
		}
		else
		{
			throw new \RuntimeException('Unable to determine type for $identifier');
		}

		$user = fake(UserFaker::class);
		model(GroupModel::class)->addUserToGroup($user->id, $id);

		return $user;
	}
}

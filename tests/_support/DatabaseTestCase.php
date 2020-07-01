<?php namespace Tests\Support;

use CodeIgniter\Session\Handlers\ArrayHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\Mock\MockEmail;
use CodeIgniter\Test\Mock\MockSession;
use Config\Services;
use Faker\Factory;

class DatabaseTestCase extends CIDatabaseTestCase
{
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

	/**
	 * Callbacks to run during setUp.
	 *
	 * @var array of methods
	 */
	protected $setUpMethods = ['mockEmail', 'mockSession'];

    /**
     * Initializes the one-time components.
     */
    public static function setUpBeforeClass(): void
    {
    	helper('test');
		self::$faker = Factory::create();
    }

	//--------------------------------------------------------------------
	// Staging
	//--------------------------------------------------------------------

	protected function setUp(): void
	{
		parent::setUp();

		if (isset($this->setUpMethods) && is_array($this->setUpMethods))
		{
			foreach ($this->setUpMethods as $method)
			{
				$this->$method();
			}
		}
	}

	protected function tearDown(): void
	{
		parent::tearDown();

		if (isset($this->tearDownMethods) && is_array($this->tearDownMethods))
		{
			foreach ($this->tearDownMethods as $method)
			{
				$this->$method();
			}
		}
	}

	//--------------------------------------------------------------------
	// Mocking
	//--------------------------------------------------------------------

    /**
     * Injects the mock session driver into Services
     */
    protected function mockSession()
    {
    	$_SESSION = [];

        $config  = config('App');
        $session = new MockSession(new ArrayHandler($config, '0.0.0.0'), $config);

        Services::injectMock('session', $session);
    }
    /**
     * Injects the mock email driver into Services
     */
    protected function mockEmail()
    {
		// Globally mock Email so nothing really sends
        Services::injectMock('email', new MockEmail(config('Email')));
    }
}

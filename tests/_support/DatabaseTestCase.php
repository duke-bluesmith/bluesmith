<?php namespace Tests\Support;

use CodeIgniter\Session\Handlers\ArrayHandler;
use CodeIgniter\Test\CIDatabaseTestCase;
use CodeIgniter\Test\Mock\MockEmail;
use CodeIgniter\Test\Mock\MockSession;
use Config\Services;
use Faker\Factory;
use Tests\Support\Simulator;

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

    /**
     * Initialize the simulation, if it has not been.
     */
	protected function simulateOnce()
	{
		// Initialize the simulation only once since it is costly.
		if (! Simulator::$initialized)
		{
			Simulator::initialize();
		}
	}
}

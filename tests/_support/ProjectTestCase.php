<?php namespace Tests\Support;

use App\Database\Seeds\InitialSeeder;
use CodeIgniter\Test\CIUnitTestCase;

class ProjectTestCase extends CIUnitTestCase
{
	/**
	 * Methods to run during tearDown.
	 *
	 * @var array of methods
	 */
	protected $tearDownMethods = ['resetServices'];

	//--------------------------------------------------------------------
	// Database Properties
	//--------------------------------------------------------------------

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
	protected $seed = InitialSeeder::class;

	//--------------------------------------------------------------------
	// Staging
	//--------------------------------------------------------------------

	/**
	 * Initializes required helpers.
	 *
	 * @see app/Config/Events.php "post_controller_constructor"
	 */
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		helper(['alerts', 'auth', 'html']);
	}
}

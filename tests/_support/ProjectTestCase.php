<?php

namespace Tests\Support;

use App\Database\Seeds\InitialSeeder;
use CodeIgniter\Settings\Handlers\ArrayHandler;
use CodeIgniter\Settings\Settings;
use CodeIgniter\Test\CIUnitTestCase;
use Config\Services;
use Nexus\PHPUnit\Extension\Expeditable;

/**
 * @internal
 */
abstract class ProjectTestCase extends CIUnitTestCase
{
    use Expeditable;

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
     * @var array|string|null
     */
    protected $namespace;

    /**
     * The seed file(s) used for all tests within this test case.
     * Should be fully-namespaced or relative to $basePath
     *
     * @var array|string
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

        helper(['alerts', 'auth', 'currency', 'html', 'number', 'preferences', 'themes']);
    }

    /**
     * Force Settings ArrayHandler for faster & easier tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config           = config('Settings');
        $config->handlers = ['array'];
        $settings         = new Settings($config);

        Services::injectMock('settings', $settings);
    }
}

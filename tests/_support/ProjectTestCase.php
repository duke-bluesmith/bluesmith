<?php namespace ProjectTests\Support;

class ProjectTestCase extends \CodeIgniter\Test\CIDatabaseTestCase
{
    /**
     * Should the database be refreshed before each test?
     *
     * @var boolean
     */
    protected $refresh = true;

    /**
     * The name of a seed file used for all tests within this test case.
     *
     * @var string
     */
    protected $seed = 'ProjectTests\Support\Database\Seeds\TestSeeder';

    /**
     * The path to where we can find the test Seeds directory.
     *
     * @var string
     */
    protected $basePath = SUPPORTPATH . 'Database/';

    /**
     * The namespace to help us find the migration classes.
     *
     * @var string
     */
    protected $namespace = 'ProjectTests\Support';
    
    /**
     * @var SessionHandler
     */
    protected $session;

    public function setUp(): void
    {        
        parent::setUp();

        $this->mockSession();
    }

    /**
     * Pre-loads the mock session driver into $this->session.
     *
     * @var string
     */
    protected function mockSession()
    {
        require_once CIPATH . 'tests/_support/Session/MockSession.php';
        $config = config('App');
        $this->session = new MockSession(new ArrayHandler($config, '0.0.0.0'), $config);
        \Config\Services::injectMock('session', $this->session);
    }
}

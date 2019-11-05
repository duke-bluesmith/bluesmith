<?php namespace ProjectTests\Support;

use CodeIgniter\Session\Handlers\ArrayHandler;
use Config\Database;
use Tests\Support\Session\MockSession;

class ProjectTestCase extends \CodeIgniter\Test\CIDatabaseTestCase
{
	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;
	
	/**
	 * @var SessionHandler
	 */
	protected $session;

	public function setUp(): void
	{
		// Handle resets here instead of in parent
		$tmpReset = $this->refresh;
		$this->refresh = false;

		parent::setUp();
		
		// Refresh the database to the initial test state
		if ($tmpReset === true)
		{
			$this->resetTables();

			// Run all migrations
			$this->migrations->setNamespace(false);
			$this->migrations->latest('tests');

			// Seed the database
			$this->seeder->setPath(PROJECTSUPPORTPATH . 'Database/Seeds');
			$this->seed('ProjectTests\Support\Database\Seeds\TestSeeder');
		}

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

	/**
	 * Remove all test tables except migrations.
	 *
	 */
	protected function resetTables()
	{
		// Reset migrations
		$this->db->table('migrations')->truncate();
		
		// Check for tables
		$tables = $this->db->listTables();
		
		if (empty($tables))
		{
			return;
		}
		
		$forge = Database::forge('tests');

		foreach ($tables as $table)
		{
			if ($table === $this->db->DBPrefix . 'migrations')
			{
				continue;
			}

			$forge->dropTable($table, true);
		}
	}
	
	
	public function tearDown(): void
	{
		parent::tearDown();
	}
}

<?php

use App\Models\JobModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Myth\Auth\Authorization\GroupModel;
use Tests\Support\ProjectTestCase;
use Tests\Support\Simulator;

/**
 * Tests for the internal version of the simulator
 */
class SimulatorTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	/**
	 * Should run db migration only once?
	 *
	 * @var boolean
	 */
	protected $migrateOnce = true;

	/**
	 * Should run seeding only once?
	 *
	 * @var boolean
	 */
	protected $seedOnce = true;

	/**
	 * Should the db be refreshed before test?
	 *
	 * @var boolean
	 */
	protected $refresh = false;

	/**
	 * Initializes the simulation only
	 * once since it is costly.
	 */
	protected function setUp(): void
	{
		parent::setUp();

		if (! Simulator::$initialized)
		{
			Simulator::initialize();
		}
	}

	public function testDoesRegisterAppActions()
	{
		$this->seeInDatabase('actions', ['uid' => 'approve']);
	}

	public function testDoesAssignJobsToUsers()
	{
		$job = model(JobModel::class)->first();

		$result = $job->users;

		$this->assertIsArray($result);
		$this->assertGreaterThan(0, $result);
	}

	public function testDoesAssignUsersToGroups()
	{
		// Gather the groups
		$groups = model(GroupModel::class)->findAll();
		$this->assertGreaterThanOrEqual(4, count($groups));

		// Check that each group has at least one user
		foreach ($groups as $group)
		{
			$users = model(GroupModel::class)->getUsersForGroup($group->id);
			$this->assertGreaterThanOrEqual(1, $users);
		}
	}
}

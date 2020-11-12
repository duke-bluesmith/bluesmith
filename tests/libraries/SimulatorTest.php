<?php

use App\Models\JobModel;
use Myth\Auth\Authorization\GroupModel;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Simulator;

/**
 * Tests for the internal version of the simulator
 */
class SimulatorTest extends DatabaseTestCase
{
	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = false;

	protected function setUp(): void
	{
		parent::setUp();

		$this->simulateOnce();
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

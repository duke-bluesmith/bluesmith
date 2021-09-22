<?php

use CodeIgniter\Test\DatabaseTestTrait;
use Myth\Auth\Authorization\GroupModel;
use Tests\Support\ProjectTestCase;
use Tests\Support\Simulator;

/**
 * Tests for the internal version of the simulator
 *
 * @internal
 */
final class SimulatorTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	// Initialize the database once
	protected $migrateOnce = true;
	protected $seedOnce    = true;

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

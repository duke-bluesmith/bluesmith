<?php

use App\Models\JobModel;
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

		// Initialize the simulation only once since it is costly.
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
}

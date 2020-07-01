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
	 * Has the simluator been initialized
	 *
	 * @var boolean
	 */
	protected $simulated = false;

	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;

    protected function setUp(): void
    {
		parent::setUp();

		// Initialize the simulation only once since it is costly.
		if (! $this->simulated)
		{
			Simulator::initialize();
			$this->simulated = true;
			$this->refresh   = false;
		}
	}

	public function testDoesRegisterAppTasks()
	{
		$this->seeInDatabase('tasks', ['uid' => 'approve']);
	}

	public function testDoesAssignJobsToUsers()
	{
		$job = model(JobModel::class)->first();

		$result = $job->users;

		$this->assertIsArray($result);
		$this->assertGreaterThan(0, $result);
	}
}

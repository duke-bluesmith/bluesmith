<?php

use App\Entities\Job;
use App\Controllers\Manage\Jobs;
use App\Models\JobModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

class JobsControllerTest extends ProjectTestCase
{
	use ControllerTester, DatabaseTestTrait;

	protected $migrateOnce = true;
	protected $seedOnce    = true;
	protected $namespace   = [
		'Tatter\Outbox',
		'Tatter\Settings',
		'Tatter\Themes',
		'Tatter\Workflows',
		'Myth\Auth',
		'App',
	];

	/**
	 * Whether the test Jobs have been created
	 *
	 * @var bool
	 */
	private $jobbed = false;

	/**
	 * An active staff Job
	 *
	 * @var Job
	 */
	private $staff;

	/**
	 * An active client Job
	 *
	 * @var Job
	 */
	private $client;

	/**
	 * A completed Job
	 *
	 * @var Job
	 */
	private $completed;

	/**
	 * A deleted Job
	 *
	 * @var Job
	 */
	private $deleted;

	/**
	 * Sets up the Controller for testing.
	 */
	protected function setUp(): void
	{
		parent::setUp();

		// Create the test Jobs once
		if (! $this->jobbed)
		{
			$this->staff = fake(JobModel::class, [
				'workflow_id' => 1,
				'stage_id'    => 6, // charges
			]);

			$this->client = fake(JobModel::class, [
				'workflow_id' => 1,
				'stage_id'    => 1, // info
			]);

			$this->completed = fake(JobModel::class, [
				'stage_id' => null,
			]);

			$this->deleted = fake(JobModel::class, [
				'deleted_at' => Time::now()->toDatetimeString(),
			]);

			$this->jobbed = true;
		}

		$this->controller(Jobs::class);
	}

	/**
	 * @dataProvider indexDataProvider
	 * @timeLimit 0.75
	 */
	public function testIndexHasCorrectJobs(string $method, array $expected)
	{
		$result = $this->execute($method);
		$result->assertOK();
		$result->assertStatus(200);

		// Check that each expected Job is present and others are not
		foreach (['staff', 'client', 'completed', 'deleted'] as $type)
		{
			if (in_array($type, $expected))
			{
				// Check for the Job name linked by its ID
				$result->see(anchor('jobs/show/' . $this->$type->id, $this->$type->name));
			}
			else
			{
				$result->dontSee($this->$type->name);
			}
		}
	}

	public function indexDataProvider(): array
	{
		return [
			['staff', ['staff']],
			['active', ['staff', 'client']],
			['archive', ['completed']],
			['all', ['staff', 'client', 'completed']],
			['trash', ['deleted']],
		];
	}
}

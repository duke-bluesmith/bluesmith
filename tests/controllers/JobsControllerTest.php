<?php

use App\Entities\Job;
use App\Controllers\Manage\Jobs;
use App\Models\JobModel;
use App\Models\MaterialModel;
use App\Models\MethodModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\ControllerTester;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

class JobsControllerTest extends ProjectTestCase
{
	use ControllerTester, DatabaseTestTrait;

	const JOBS = ['staff', 'client', 'completed', 'deleted'];

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

		// Create the necessary relations (Fabricator will assign them)
		fake(MethodModel::class);
		fake(MaterialModel::class);

		// Create the test Jobs once
		if (! $this->jobbed)
		{
			$this->jobbed = true;

			$this->staff = fake(JobModel::class, [
				'name'        => 'staff job',
				'workflow_id' => 1,
				'stage_id'    => 6, // charges
			]);

			$this->client = fake(JobModel::class, [
				'name'        => 'client job',
				'workflow_id' => 1,
				'stage_id'    => 1, // info
			]);

			$this->completed = fake(JobModel::class, [
				'name'        => 'completed job',
				'workflow_id' => 1,
				'stage_id'    => null,
			]);

			$this->deleted = fake(JobModel::class, [
				'name'        => 'deleted job',
				'workflow_id' => 1,
				'stage_id'    => 1, // info
			]);
			model(JobModel::class)->delete($this->deleted->id);
			$this->deleted->deleted_at = Time::now()->toDatetimeString();

			// Add a User to each Job so the left join completes
			$user = fake(UserModel::class);
			foreach (self::JOBS as $type)
			{
				model(JobModel::class)->addUserToJob($user->id, $this->$type->id);
			}

			// Cache the compiled rows
			model(JobModel::class)->getCompiledRows();
		}

		$this->controller(Jobs::class);
	}

	/**
	 * @dataProvider indexDataProvider
	 */
	public function testIndexHasCorrectJobs(string $method, array $expected)
	{
		$result = $this->execute($method);
		$result->assertOK();
		$result->assertStatus(200);

		// Check that each expected Job is present and others are not
		foreach (self::JOBS as $type)
		{
			if (in_array($type, $expected))
			{
				// Check for the Job name linked by its ID
				$result->assertSee(anchor('jobs/show/' . $this->$type->id, $this->$type->name));
			}
			else
			{
				$result->assertDontSee($this->$type->name);
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

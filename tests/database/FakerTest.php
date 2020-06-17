<?php

use App\Models\JobModel;
use App\Models\UserModel;
use Tatter\Workflows\Models\StageModel;

/**
 * Tests for the faker methods
 */
class FakerTest extends Tests\Support\TestCase
{
	use Tests\Support\Traits\FakerTrait;

	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;
	
	public function setUp(): void
	{
		parent::setUp();

		$this->fakerSetUp();
	}

	public function testCreateAddsToDatabase()
	{
		$model = new JobModel();

		$expected = $this->createFaked('job');

		$this->assertEquals($expected, $model->findColumn('id'));
	}

	public function testCreateUser()
	{
		$model = new UserModel();

		$ids = $this->createFaked('User');

		$user = $model->find(reset($ids));

		$this->assertInstanceOf('App\Entities\User', $user);
	}

	public function testCreateAddsNumRows()
	{
		$num   = 20;
		$model = new JobModel();

		$this->createFaked('job', $num);

		$this->assertCount($num, $model->findColumn('id'));
	}

	public function testFullMakesValidJobs()
	{
		$jobs   = new JobModel();
		$stages = new StageModel();

		$this->fullFake();

		$job   = $jobs->first();
		$stage = $stages->find($job->stage_id);

		$this->assertEquals($job->workflow_id, $stage->workflow_id);
	}
}

<?php namespace App\Models;

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;
use Tests\Support\Simulator;

class JobModelTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	protected $migrateOnce = true;
	protected $seedOnce    = true;
	protected $refresh     = false;

	public function testAddEmailToJob()
	{
		model(JobModel::class)->addEmailtoJob(23, 42);

		$this->seeInDatabase('emails_jobs', ['job_id' => 42]);
	}

	public function testAddUserToJob()
	{
		$user = fake(UserModel::class);
		$job  = fake(JobModel::class);

		model(JobModel::class)->addUserToJob($user->id, $job->id);

		$result = $user->jobs;

		$this->assertCount(1, $result);
		$this->assertEquals($job->id, $result[0]->id);
	}

	public function testCompiledRowsDefault()
	{
		Simulator::initialize();

		$result = model(JobModel::class)->getCompiledRows();

		$this->assertIsArray($result);
		$this->assertGreaterThanOrEqual(1, count($result));

		$expected = [
			'id',
			'name',
			'summary',
			'workflow_id',
			'stage_id',
			'created_at',
			'updated_at',
			'deleted_at',
			'material_id',
			'method',
			'user_id',
			'firstname',
			'lastname',
			'workflow',
			'action',
			'role',
		];

		$this->assertEquals($expected, array_keys($result[0]));
	}

	public function testClearCompiledRows()
	{
		cache()->save('jobsrows', ['foo' => 'bar']);

		model(JobModel::class)->clearCompiledRows();
		$result = model(JobModel::class)->getCompiledRows();

		$this->assertEquals([], $result);
	}

	public function testCompiledRowsCreatesCache()
	{
		$this->assertNull(cache()->get('jobsrows'));

		model(JobModel::class)->getCompiledRows();

		$this->assertNotNull(cache()->get('jobsrows'));
	}

	public function testCompiledRowsUsesCache()
	{
		$expected = ['foo' => 'bar'];
		cache()->save('jobsrows', $expected);

		$result = model(JobModel::class)->getCompiledRows();

		$this->assertSame($expected, $result);
	}

	public function testEventClearsCompiledRowsCache()
	{
		cache()->save('jobsrows', ['foo' => 'bar']);

		fake(JobModel::class);

		$this->assertNull(cache()->get('jobsrows'));
	}
}

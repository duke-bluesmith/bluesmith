<?php

use App\Models\JobModel;
use App\Models\UserModel;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Simulator;

class JobModelTest extends DatabaseTestCase
{
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
		$this->assertArrayHasKey('workflow', $result[0]);
		$this->assertArrayHasKey('firstname', $result[0]);
		$this->assertArrayHasKey('role', $result[0]);
	}

	public function testCompiledRowsCreatesCache()
	{
		$this->assertNull(cache()->get('jobrows'));

		model(JobModel::class)->getCompiledRows();

		$this->assertNotNull(cache()->get('jobrows'));
	}

	public function testCompiledRowsUsesCache()
	{
		$expected = ['foo' => 'bar'];
		cache()->save('jobrows', $expected);

		$result = model(JobModel::class)->getCompiledRows();

		$this->assertSame($expected, $result);
	}

	public function testEventClearsCompiledRowsCache()
	{
		cache()->save('jobrows', ['foo' => 'bar']);

		fake(JobModel::class);

		$this->assertNull(cache()->get('jobrows'));
	}
}

<?php

use Tests\Support\Fakers\JobFaker;
use Tests\Support\Fakers\UserFaker;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Simulator;

class JobModelTest extends DatabaseTestCase
{
	public function testAddUserToJob()
	{
		$user = fake(UserFaker::class);
		$job  = fake(JobFaker::class);

		model(JobFaker::class)->addUserToJob($user->id, $job->id);

		$result = $user->jobs;

		$this->assertCount(1, $result);
		$this->assertEquals($job->id, $result[0]->id);
	}

	public function testCompiledRowsDefault()
	{
		Simulator::initialize();

		$result = model(JobFaker::class)->getCompiledRows();

		$this->assertIsArray($result);
		$this->assertGreaterThanOrEqual(1, count($result));
		$this->assertArrayHasKey('workflow', $result[0]);
		$this->assertArrayHasKey('firstname', $result[0]);
		$this->assertArrayHasKey('role', $result[0]);
	}

	public function testCompiledRowsCreatesCache()
	{
		$this->assertNull(cache()->get('jobrows'));

		model(JobFaker::class)->getCompiledRows();

		$this->assertNotNull(cache()->get('jobrows'));
	}

	public function testCompiledRowsUsesCache()
	{
		$expected = ['foo' => 'bar'];
		cache()->save('jobrows', $expected);

		$result = model(JobFaker::class)->getCompiledRows();

		$this->assertSame($expected, $result);
	}

	public function testEventClearsCompiledRowsCache()
	{
		cache()->save('jobrows', ['foo' => 'bar']);

		fake(JobFaker::class);

		$this->assertNull(cache()->get('jobrows'));
	}
}

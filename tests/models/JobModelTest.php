<?php

use Tests\Support\Fakers\JobFaker;
use Tests\Support\Fakers\UserFaker;
use Tests\Support\DatabaseTestCase;

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
}

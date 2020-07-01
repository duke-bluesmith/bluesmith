<?php

use Tests\Support\DatabaseTestCase;
use Tests\Support\Fakers\JobFaker;

class JobTest extends DatabaseTestCase
{
	public function setUp(): void
	{
		parent::setUp();
				
		// Create a random job
		$this->job = fake(JobFaker::class);
	}

	public function testSetOptionsAddsToDatabase()
	{
		$this->job->setOptions([1, 2, 3]);

		$this->seeNumRecords(3, 'jobs_options', ['job_id' => 1]);
	}

	public function testHasOptionEmpty()
	{
		$this->assertFalse($this->job->hasOption(1));
	}

	public function testHasOptionTrue()
	{
		$this->job->setOptions([1, 2, 3]);

		$this->assertTrue($this->job->hasOption(1));
	}
}

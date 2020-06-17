<?php

class JobTest extends Tests\Support\TestCase
{
	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;
	
	public function setUp(): void
	{
		parent::setUp();
		
		$this->model = new \App\Models\JobModel();
				
		// Create some mock jobs
		$builder = $this->db->table('jobs');
		$this->jobs = [
			[
				'name'        => 'Durham Bull',
				'summary'     => 'A 3D scanned version of the downtown Bull',
				'workflow_id' => 1,
				'stage_id'    => 1,
				'material_id' => 1,
			],
			[
				'name'        => 'Duck whistle',
				'summary'     => 'Please help me make this duck whistle',
				'workflow_id' => 2,
				'stage_id'    => 3,
				'material_id' => 4,
			],
		];
		
		foreach ($this->jobs as $job)
		{
			$builder->insert($job);
		}
	}

	public function testSetOptionsAddsToDatabase()
	{
		$job = $this->model->find(1);
		$job->setOptions([1, 2, 3]);
		
		$result = $this->db
			->table('jobs_options')
			->where('job_id', 1)
			->get()->getResult();

		$this->assertCount(3, $result);
	}

	public function testHasOptionEmpty()
	{
		$job = $this->model->find(1);

		$this->assertFalse($job->hasOption(1));
	}

	public function testHasOptionTrue()
	{
		$job = $this->model->find(1);
		$job->setOptions([1, 2, 3]);

		$this->assertTrue($job->hasOption(1));
	}
}

<?php

class JobTest extends ProjectTests\Support\ProjectTestCase
{
	public function setUp(): void
	{
		parent::setUp();
		
		$this->model = new \App\Models\JobModel();
				
		// Create some mock jobs
		$builder = $this->db->table('jobs');
		$jobs = [
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
		
		foreach ($jobs as $job)
		{
			$builder->insert($job);
		}
	}

	public function testHasOptionEmpty()
	{
		$job = $this->model->find(1);

		$this->assertFalse($job->hasOption(1));
	}
}

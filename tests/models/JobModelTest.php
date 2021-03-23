<?php namespace App\Models;

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;
use Tests\Support\Simulator;

class JobModelTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	// Initialize the database once
	protected $migrateOnce = true;
	protected $seedOnce    = true;

	public function testAddEmailToJob()
	{
		model(JobModel::class)->addEmailtoJob(23, 42);

		$this->seeInDatabase('emails_jobs', ['job_id' => 42]);
	}

	public function testAddUserToJob()
	{
		model(JobModel::class)->addUserToJob(123, 456);

		$this->seeInDatabase('jobs_users', [
			'job_id'  => 456,
			'user_id' => 123,
		]);
	}

	/**
	 * @slowThreshold 2500
	 */
	public function testFetchCompiledRows()
	{
		Simulator::initialize();

		$method = $this->getPrivateMethodInvoker(model(JobModel::class), 'fetchCompiledRows');
		$result = $method();

		$this->assertIsArray($result);
		$this->assertGreaterThanOrEqual(1, count($result));

		$expected = [
			'action',
			'created_at',
			'deleted_at',
			'firstname',
			'id',
			'lastname',
			'material_id',
			'method',
			'name',
			'role',
			'stage_id',
			'summary',
			'updated_at',
			'user_id',
			'workflow',
			'workflow_id',
		];

		$keys = array_keys($result[0]);
		sort($keys, SORT_STRING);

		$this->assertEquals($expected, $keys);
	}
}

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
}

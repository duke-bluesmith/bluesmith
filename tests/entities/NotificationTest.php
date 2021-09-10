<?php

namespace App\Entities;

use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

class NotificationTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	// Initialize the database once
	protected $migrateOnce = true;
	protected $seedOnce    = true;

	/**
	 * @var Job|null
	 */
	private $job;

	/**
	 * @var User|null
	 */
	private $user;

	/**
	 * Creates test relations
	 */
	protected function setUp(): void
	{
		parent::setUp();

		if ($this->job === null)
		{
			$this->job = fake(JobModel::class);
		}

		if ($this->user === null)
		{
			$this->user = fake(UserModel::class);
		}
	}

	public function testValidatesInput()
	{
		$this->expectException('InvalidArgumentException');
		$this->expectExceptionMessage('The content field is required.');

		new Notification([
			'job_id'     => $this->job->id,
			'user_id'    => $this->user->id,
			'name'       => 'Test',
			'status'     => 'Test',
			'created_at' => new Time(),
		]);
	}

	public function testGetJob()
	{
		$notification = new Notification([
			'job_id'     => $this->job->id,
			'job_name'   => 'Test Job',
			'user_id'    => $this->user->id,
			'user_name'  => 'Test User',
			'status'     => 'Test',
			'content'    => 'Test',
			'created_at' => new Time(),
		]);

		$result = $notification->getJob();

		$this->assertEquals($this->job, $result);
	}

	public function testGetUser()
	{
		$notification = new Notification([
			'job_id'     => $this->job->id,
			'job_name'   => 'Test Job',
			'user_id'    => $this->user->id,
			'user_name'  => 'Test User',
			'status'     => 'Test',
			'content'    => 'Test',
			'created_at' => new Time(),
		]);

		$result = $notification->getUser();

		$this->assertEquals($this->user, $result);
	}
}
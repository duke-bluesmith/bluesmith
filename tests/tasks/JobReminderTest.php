<?php

use App\Entities\Job;
use App\Models\JobModel;
use App\Commands\JobReminder;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class JobReminderTest extends ProjectTestCase
{
	/**
	 * @var JobReminder
	 */
	private $task;

    protected function setUp(): void
    {
		parent::setUp();

		model(JobModel::class)->clearCompiledRows();
		$this->task = new JobReminder(service('logger'), service('commands'));
	}

    public function testGetRows()
    {
    	// Stage a job row
    	cache()->save('jobsrows', [
    		[
    			'id'         => 1,
    			'stage_id'   => 5,
    			'role'       => '',
    			'updated_at' => Time::yesterday(),
    			'deleted_at' => null,
    		],
    	]);

		$result = $this->task->getRows();

		$this->assertCount(1, $result);
		$this->assertSame(1, $result[0]['id']);
    }

    public function testGetRowsIgnoresDeleted()
    {
    	// Stage a job row
    	cache()->save('jobsrows', [
    		[
    			'id'         => 1,
    			'stage_id'   => 5,
    			'role'       => '',
    			'updated_at' => Time::yesterday(),
    			'deleted_at' => Time::now(),
    		],
    	]);

		$result = $this->task->getRows();

		$this->assertCount(0, $result);
    }

    public function testGetRowsIgnoresCompleted()
    {
    	// Stage a job row
    	cache()->save('jobsrows', [
    		[
    			'id'         => 1,
    			'stage_id'   => null,
    			'role'       => '',
    			'updated_at' => Time::yesterday(),
    			'deleted_at' => null,
    		],
    	]);

		$result = $this->task->getRows();

		$this->assertCount(0, $result);
    }

    public function testGetRowsIgnoresStaff()
    {
    	// Stage a job row
    	cache()->save('jobsrows', [
    		[
    			'id'         => 1,
    			'stage_id'   => 5,
    			'role'       => 'manageAny',
    			'updated_at' => Time::yesterday(),
    			'deleted_at' => null,
    		],
    	]);

		$result = $this->task->getRows();

		$this->assertCount(0, $result);
    }

    public function testGetRowsIgnoresRecent()
    {
    	// Stage a job row
    	cache()->save('jobsrows', [
    		[
    			'id'         => 1,
    			'stage_id'   => 5,
    			'role'       => 'manageAny',
    			'updated_at' => Time::now(),
    			'deleted_at' => null,
    		],
    	]);

		$result = $this->task->getRows();

		$this->assertCount(0, $result);
    }
}

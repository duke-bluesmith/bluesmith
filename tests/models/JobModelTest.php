<?php

namespace App\Models;

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;
use Tests\Support\Simulator;

/**
 * @internal
 */
final class JobModelTest extends ProjectTestCase
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

        $this->assertSame($expected, $keys);
    }

    public function testInsertCreatesJoblog()
    {
        $jobId = model(JobModel::class)->insert([
            'name'        => 'Banana Job',
            'summary'     => 'A job for fruit lovers',
            'workflow_id' => 1,
            'stage_id'    => 42,
        ]);

        $this->seeInDatabase('joblogs', [
            'job_id'     => $jobId,
            'stage_from' => null,
            'stage_to'   => 42,
        ]);
    }

    public function testUpdateCreatesJoblog()
    {
        $job = fake(JobModel::class);

        model(JobModel::class)->update($job->id, [
            'stage_id' => $job->stage_id + 1,
        ]);

        $this->seeInDatabase('joblogs', [
            'job_id'     => $job->id,
            'stage_from' => $job->stage_id,
            'stage_to'   => $job->stage_id + 1,
        ]);
    }
}

<?php

namespace App\Entities;

use App\Models\JobModel;
use App\Models\LedgerModel;
use App\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class JobTest extends ProjectTestCase
{
    use DatabaseTestTrait;

    protected $namespace = [
        'Tatter\Files',
        'Tatter\Workflows',
        'Myth\Auth',
        'App',
    ];

    protected $seed = 'App\Database\Seeds\OptionSeeder';

    /**
     * @var Job
     */
    private $job;

    /**
     * Fakes a test Job.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->job = fake(JobModel::class);
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

        $this->assertTrue($this->job->hasOption(2));
    }

    public function testGetLedgersReturnsLedgers()
    {
        model(LedgerModel::class)->insert([
            'job_id'   => $this->job->id,
            'estimate' => 0,
        ]);
        model(LedgerModel::class)->insert([
            'job_id'   => $this->job->id,
            'estimate' => 1,
        ]);

        $result = $this->job->getLedgers();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);

        foreach ($result as $ledger) {
            $this->assertInstanceOf(Ledger::class, $ledger);
        }
    }

    public function testEstimateReturnsNull()
    {
        $result = $this->job->estimate;

        $this->assertNull($result);
    }

    public function testEstimateReturnsLedger()
    {
        $result = model(LedgerModel::class)->insert([
            'job_id'   => $this->job->id,
            'estimate' => 1,
        ]);

        $result = $this->job->estimate;

        $this->assertInstanceOf(Ledger::class, $result);
        $this->assertTrue($result->estimate);
    }

    public function testEstimateCreatesLedger()
    {
        $result = $this->job->getEstimate(true);

        $this->assertInstanceOf(Ledger::class, $result);
        $this->assertTrue($result->estimate);
    }

    public function testInvoiceReturnsInvoice()
    {
        $result = model(LedgerModel::class)->insert([
            'job_id'   => $this->job->id,
            'estimate' => 0,
        ]);

        $result = $this->job->invoice;

        $this->assertInstanceOf(Ledger::class, $result);
        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertFalse($result->estimate);
    }

    public function testInvoiceCreatesLedger()
    {
        $result = $this->job->getInvoice(true);

        $this->assertInstanceOf(Ledger::class, $result);
        $this->assertFalse($result->estimate);
    }

    public function testInvoiceReturnsNull()
    {
        $result = $this->job->getInvoice(false);

        $this->assertNull($result);
    }

    public function testGetOwner()
    {
        $user1 = fake(UserModel::class);
        $user2 = fake(UserModel::class);

        model(JobModel::class)->addUserToJob($user1->id, $this->job->id);
        model(JobModel::class)->addUserToJob($user2->id, $this->job->id);

        $result = $this->job->getOwner();

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame($user1->id, $result->id);
    }
}

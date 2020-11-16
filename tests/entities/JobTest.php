<?php namespace App\Entities;

use App\Models\LedgerModel;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Fakers\JobFaker;

class JobTest extends DatabaseTestCase
{
	/**
	 * @var Job
	 */
	protected $job;

	protected function setUp(): void
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

	public function testGetLedgersReturnsLedgers()
	{
		model(LedgerModel::class)->insert([
			'job_id'      => $this->job->id,
			'estimate'    => 0,
		]);
		model(LedgerModel::class)->insert([
			'job_id'      => $this->job->id,
			'estimate'    => 1,
		]);

		$result = $this->job->getLedgers();

		$this->assertIsArray($result);
		$this->assertEquals([false, true], array_keys($result));
		$this->assertInstanceOf(Ledger::class, $result[false]);
		$this->assertInstanceOf(Ledger::class, $result[true]);
	
	}

	public function testEstimateReturnsNull()
	{
		$result = $this->job->estimate;

		$this->assertNull($result);
	}

	public function testEstimateReturnsLedger()
	{
		$result = model(LedgerModel::class)->insert([
			'job_id'      => $this->job->id,
			'estimate'    => 1,
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

	public function testInvoiceReturnsLedger()
	{
		$result = model(LedgerModel::class)->insert([
			'job_id'   => $this->job->id,
			'estimate' => 0,
		]);

		$result = $this->job->invoice;

		$this->assertInstanceOf(Ledger::class, $result);
		$this->assertFalse($result->estimate);
	}

	public function testInvoiceCreatesLedger()
	{
		$result = $this->job->getInvoice(true);

		$this->assertInstanceOf(Ledger::class, $result);
		$this->assertFalse($result->estimate);
	}
}

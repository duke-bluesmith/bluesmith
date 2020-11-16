<?php namespace App\Entities;

use App\Models\InvoiceModel;
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

	public function testBillReturnsInvoice()
	{
		$result = model(InvoiceModel::class)->insert([
			'job_id'      => $this->job->id,
			'estimate'    => 1,
		]);

		$result = $this->job->estimate;

		$this->assertInstanceOf(Invoice::class, $result);
		$this->assertFalse($result->estimate);
	}

	public function testEstimateReturnsInvoice()
	{
		$result = model(InvoiceModel::class)->insert([
			'job_id'      => $this->job->id,
			'estimate'    => 1,
		]);

		$result = $this->job->estimate;

		$this->assertInstanceOf(Invoice::class, $result);
		$this->assertTrue($result->estimate);
	}
}

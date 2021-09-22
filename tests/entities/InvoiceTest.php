<?php

namespace App\Entities;

use Tests\Support\CurrencyTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class InvoiceTest extends ProjectTestCase
{
	use CurrencyTrait;

	/**
	 * @var Invoice
	 */
	private $invoice;

	/**
	 * @var Payment[]
	 */
	private $payments = [];

	/**
	 * Mocks the Settings service and creates a
	 * test Invoice with some Payments.
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->invoice = new Invoice([
			'id'          => 3,
			'job_id'      => 1,
			'description' => 'Test Invoice',
		]);

		// Create some test Payments
		for ($i = 1; $i < 5; $i++)
		{
			$this->payments[] = new Payment([
				'ledger_id' => $this->invoice->id,
				'user_id'   => 1,
				'amount'    => $i * 1000,
				'class'     => 'Banana',
				'code'      => 0,
			]);
		}

		// Inject the Payments into the test Invoice
		$this->invoice->payments = $this->payments;
	}

	public function testGetPaidReturnsSum()
	{
		$result = $this->invoice->getPaid();

		$this->assertSame(10000, $result);
	}

	public function testGetPaidFormatted()
	{
		$result = $this->invoice->getPaid(true);

		$this->assertSame('$100.00', $result);
	}
}

<?php namespace App\Entities;

use App\Models\ChargeModel;
use App\Models\InvoiceModel;
use Tatter\Settings\Models\SettingModel;
use Tests\Support\DatabaseTestCase;

class InvoiceTest extends DatabaseTestCase
{
	/**
	 * @var Invoice
	 */
	protected $invoice;

	protected function setUp(): void
	{
		parent::setUp();

		// Lock down currency settings
		model(SettingModel::class)->where('name', 'currencyUnit')->update(null, ['content' => 'USD']);
		model(SettingModel::class)->where('name', 'currencyScale')->update(null, ['content' => 100]);

		// Create an invoice
		$id = model(InvoiceModel::class)->insert([
			'job_id'      => 1,
			'description' => 'Test invoice',
		]);
		$this->invoice = model(InvoiceModel::class)->find($id);
	}

	public function testGetTotalReturnsSum()
	{
		for ($i=1; $i<5; $i++)
		{
			model(ChargeModel::class)->insert([
				'name'       => $i,
				'invoice_id' => $this->invoice->id,
				'price'      => $i * 1000,
			]);
		}

		$result = $this->invoice->getTotal();

		$this->assertEquals(10000, $result);
	}
}

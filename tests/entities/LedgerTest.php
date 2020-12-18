<?php namespace App\Entities;

use App\Models\ChargeModel;
use App\Models\LedgerModel;
use Tatter\Settings\Models\SettingModel;
use Tests\Support\DatabaseTestCase;

class LedgerTest extends DatabaseTestCase
{
	/**
	 * @var Ledger
	 */
	protected $ledger;

	protected function setUp(): void
	{
		parent::setUp();

		// Lock down currency settings
		model(SettingModel::class)->where('name', 'currencyUnit')->update(null, ['content' => 'USD']);
		model(SettingModel::class)->where('name', 'currencyScale')->update(null, ['content' => 100]);

		// Create a Ledger
		$id = model(LedgerModel::class)->insert([
			'job_id'      => 1,
			'description' => 'Test Ledger',
		]);
		$this->ledger = model(LedgerModel::class)->find($id);
	}

	public function testGetTotalReturnsSum()
	{
		for ($i=1; $i<5; $i++)
		{
			model(ChargeModel::class)->insert([
				'name'      => $i,
				'ledger_id' => $this->ledger->id,
				'amount'    => $i * 1000,
			]);
		}

		$result = $this->ledger->getTotal();

		$this->assertEquals(10000, $result);
	}
}

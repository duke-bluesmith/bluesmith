<?php namespace App\Entities;

use Tatter\Settings\Models\SettingModel;
use Tests\Support\DatabaseTestCase;

class ChargeTest extends DatabaseTestCase
{
	// Locks down currency settings 
	protected function setUp(): void
	{
		parent::setUp();

		model(SettingModel::class)->where('name', 'currencyUnit')->update(null, ['content' => 'USD']);
		model(SettingModel::class)->where('name', 'currencyScale')->update(null, ['content' => 100]);
	}

	public function testGetAmountReturnsPrice()
	{
		$charge = new Charge([
			'price' => 1000,
		]);

		$result = $charge->getAmount();

		$this->assertIsInt($result);
		$this->assertEquals(1000, $result);
	}

	public function testGetAmountMultipliesQuantity()
	{
		$charge = new Charge([
			'price'    => 1000,
			'quantity' => 3,
		]);

		$result = $charge->getAmount();

		$this->assertIsInt($result);
		$this->assertEquals(3000, $result);
	}

	public function testQuantityRounds()
	{
		$charge = new Charge([
			'price'    => 1000,
			'quantity' => 0.36625363,
		]);

		$result = $charge->getAmount();

		$this->assertIsInt($result);
		$this->assertEquals(366, $result);
	}

	public function testGetAmountFormatted()
	{
		$charge = new Charge([
			'price'    => 1000,
		]);

		$result = $charge->getAmount(true);

		$this->assertIsString($result);
		$this->assertEquals('$10.00', $result);
	}

	public function testGetAmountFormattedWithCents()
	{
		$charge = new Charge([
			'price'    => 1005,
		]);

		$result = $charge->getAmount(true);

		$this->assertIsString($result);
		$this->assertEquals('$10.05', $result);
	}
}

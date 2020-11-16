<?php

use Tatter\Settings\Models\SettingModel;
use Tests\Support\DatabaseTestCase;

class CurrencyHelperTest extends DatabaseTestCase
{
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		helper('currency');
	}

	// Locks down currency settings 
	protected function setUp(): void
	{
		parent::setUp();

		model(SettingModel::class)->where('name', 'currencyUnit')->update(null, ['content' => 'USD']);
		model(SettingModel::class)->where('name', 'currencyScale')->update(null, ['content' => 100]);
	}

	public function testPriceToScaled()
	{
		$result = price_to_scaled(1000);

		$this->assertEquals(10, $result);
	}

	public function testPriceToScaledRespectsPrecision()
	{
		$result = price_to_scaled(1234.5678, 100.3333333); // @phpstan-ignore-line

		$this->assertEquals(12.34, $result);
	}

	public function testPriceToScaledFormatted()
	{
		$result = price_to_scaled(1000, null, true);

		$this->assertIsString($result);
		$this->assertEquals('10.00', $result);
	}

	public function testPriceToCurrency()
	{
		$result = price_to_currency(1005);

		$this->assertIsString($result);
		$this->assertEquals('$10.05', $result);
	}

	public function testPriceToCurrencyPrecision()
	{
		$result = price_to_currency(1005, null, null, 1);

		$this->assertIsString($result);
		$this->assertEquals('$10.0', $result);
	}
}

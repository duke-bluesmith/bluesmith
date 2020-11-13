<?php

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
}

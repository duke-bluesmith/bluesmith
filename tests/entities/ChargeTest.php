<?php namespace App\Entities;

use Config\Services;
use Tests\Support\Mock\MockSettings;
use Tests\Support\ProjectTestCase;

class ChargeTest extends ProjectTestCase
{
    /**
     * Loads the helper functions.
     */
    public static function setUpBeforeClass(): void
    {
    	parent::setUpBeforeClass();

		helper(['currency', 'number']);
    }

	/**
	 * Mocks the Settings service to eliminate the need for a database
	 */
	protected function setUp(): void
	{
		parent::setUp();

		Services::injectMock('settings', MockSettings::create());
	}

	public function testGetPriceReturnsPrice()
	{
		$charge = new Charge([
			'amount' => 1000,
		]);

		$result = $charge->getPrice();

		$this->assertIsInt($result);
		$this->assertEquals(1000, $result);
	}

	public function testGetPriceMultipliesQuantity()
	{
		$charge = new Charge([
			'amount'   => 1000,
			'quantity' => 3,
		]);

		$result = $charge->getPrice();

		$this->assertIsInt($result);
		$this->assertEquals(3000, $result);
	}

	public function testQuantityRounds()
	{
		$charge = new Charge([
			'amount'   => 1000,
			'quantity' => 0.36625363,
		]);

		$result = $charge->getPrice();

		$this->assertIsInt($result);
		$this->assertEquals(366, $result);
	}

	public function testGetPriceFormatted()
	{
		$charge = new Charge([
			'amount' => 1000,
		]);

		$result = $charge->getPrice(true);

		$this->assertIsString($result);
		$this->assertEquals('$10.00', $result);
	}

	public function testGetPriceFormattedWithCents()
	{
		$charge = new Charge([
			'amount' => 1005,
		]);

		$result = $charge->getPrice(true);

		$this->assertIsString($result);
		$this->assertEquals('$10.05', $result);
	}
}

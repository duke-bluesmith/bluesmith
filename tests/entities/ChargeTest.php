<?php

namespace App\Entities;

use Tests\Support\CurrencyTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class ChargeTest extends ProjectTestCase
{
    use CurrencyTrait;

    public function testGetPriceReturnsPrice()
    {
        $charge = new Charge([
            'amount' => 1000,
        ]);

        $result = $charge->getPrice();

        $this->assertIsInt($result);
        $this->assertSame(1000, $result);
    }

    public function testGetPriceMultipliesQuantity()
    {
        $charge = new Charge([
            'amount'   => 1000,
            'quantity' => 3,
        ]);

        $result = $charge->getPrice();

        $this->assertIsInt($result);
        $this->assertSame(3000, $result);
    }

    public function testQuantityRounds()
    {
        $charge = new Charge([
            'amount'   => 1000,
            'quantity' => 0.36625363,
        ]);

        $result = $charge->getPrice();

        $this->assertIsInt($result);
        $this->assertSame(366, $result);
    }

    public function testGetPriceFormatted()
    {
        $charge = new Charge([
            'amount' => 1000,
        ]);

        $result = $charge->getPrice(true);

        $this->assertIsString($result);
        $this->assertSame('$10.00', $result);
    }

    public function testGetPriceFormattedWithCents()
    {
        $charge = new Charge([
            'amount' => 1005,
        ]);

        $result = $charge->getPrice(true);

        $this->assertIsString($result);
        $this->assertSame('$10.05', $result);
    }
}

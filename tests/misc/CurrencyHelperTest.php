<?php

use Tests\Support\CurrencyTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class CurrencyHelperTest extends ProjectTestCase
{
    use CurrencyTrait;

    public function testPriceToScaled()
    {
        $result = price_to_scaled(1000);

        $this->assertSame(10.0, $result);
    }

    public function testPriceToScaledRespectsPrecision()
    {
        $result = price_to_scaled(1234.5678, 100.3333333); // @phpstan-ignore-line

        $this->assertSame(12.34, $result);
    }

    public function testPriceToScaledFormatted()
    {
        $result = price_to_scaled(1000, null, true);

        $this->assertIsString($result);
        $this->assertSame('10.00', $result);
    }

    public function testPriceToCurrency()
    {
        $result = price_to_currency(1005);

        $this->assertIsString($result);
        $this->assertSame('$10.05', $result);
    }

    public function testPriceToCurrencyPrecision()
    {
        $result = price_to_currency(1005, null, null, 1);

        $this->assertIsString($result);
        $this->assertSame('$10.0', $result);
    }
}

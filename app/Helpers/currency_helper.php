<?php

/**
 * Currency Helper
 *
 * Uses currency Settings (currencyUnit and currencyScale)
 * to convert between fractional monetary units and
 * scaled currency amounts.
 */

//--------------------------------------------------------------------

if (! function_exists('price_to_currency')) {
    /**
     * Converts a FMU to the currency format defined by Settings
     *
     * @param int         $price     Fractional monetary units
     * @param string|null $unit      The currency unit, defaults to value from Settings
     * @param int|null    $scale     The scale value to use, defaults to value from Settings
     * @param int|null    $precision The number of decimals to display, defaults to detection from the scale
     */
    function price_to_currency(int $price, ?string $unit = null, ?int $scale = null, ?int $precision = null): string
    {
        helper('number');

        $unit ??= service('settings')->currencyUnit;
        $scale ??= service('settings')->currencyScale;
        $precision ??= log($scale, 10);

        // Convert, e.g. cents to dollars
        $scaled = price_to_scaled($price, $scale);

        // Format the scaled amount to the currency unit
        return number_to_currency($scaled, $unit, null, $precision);
    }
}

//--------------------------------------------------------------------

if (! function_exists('price_to_scaled')) {
    /**
     * Converts a FMU to its currency norm (e.g. cents to dollars).
     * Will always restrict precision to the currency's standard (e.g. two digits for dollars).
     *
     * @param int      $price  Fractional monetary units
     * @param int|null $scale  The scale value to use, defaults to value from Settings
     * @param bool     $format Whether the result should be passed through number_format
     *
     * @return float|string
     */
    function price_to_scaled(int $price, ?int $scale = null, bool $format = false)
    {
        $scale ??= service('settings')->currencyScale;
        $scaled    = $price / $scale;
        $precision = (int) log($scale, 10);

        return $format ? number_format($scaled, $precision) : round($scaled, $precision);
    }
}

//--------------------------------------------------------------------

if (! function_exists('scaled_to_price')) {
    /**
     * Converts a currency value to its FMU (e.g. dollars to cents).
     *
     * @param float    $scaled The scaled currency value
     * @param int|null $scale  The scale value to use, defaults to value from Settings
     */
    function scaled_to_price(float $scaled, ?int $scale = null): int
    {
        $scale ??= service('settings')->currencyScale;
        $price = $scaled * $scale;

        return (int) round($price);
    }
}

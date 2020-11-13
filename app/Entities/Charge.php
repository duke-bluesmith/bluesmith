<?php namespace App\Entities;

/**
 * Charge Class
 *
 * Stores itemized charges for either a
 * job or an invoice (depending on job_id
 * or invoice_id respectively).
 * Includes some convenience methods for
 * converting and displaying values across
 * currencies. Glossary:
 *
 * - "price" is the fractional monetary unit, e.g. cents
 * - "amount" is a quantity-relative value, e.g. 10 price at 5 quantity = 50 amount
 * - "scale" is the conversion from fractional monetary unit to the currency standard, e.g. cents to dollars
 */
class Charge extends BaseEntity
{
	protected $table = 'charges';
	protected $casts = [
		'job_id'   => 'int',
		'price'    => 'int',
		'quantity' => '?float',
	];

	/**
	 * Returns the price scaled for the desired currency
	 * E.g. 1000 (cents) returns 10 (dollars)
	 *
	 * @return float
	 */
	public function getScaled(): float
	{
		$price = (int) $this->attributes['price'];
		$scale = (int) service('settings')->currencyScale;

		return $price / $scale;
	}

	/**
	 * Calculates the amount from the price and quantity.
	 *
	 * @param bool $formatted Whether to format the result for display
	 *
	 * @return string|int
	 */
	public function getAmount(bool $formatted = false)
	{
		$amount = (int) $this->attributes['price'];

		if (isset($this->attributes['quantity']))
		{
			$amount = round($amount * (float) $this->attributes['quantity']);
		}

		if (! $formatted)
		{
			return (int) $amount;
		}

		helper('number');

		// Convert price (fractional monetary unit) to its currency equivalent
		// E.g. cents to dollars
		$scale  = (int) service('settings')->currencyScale;
		$amount = $amount / $scale;

		return number_to_currency($amount, service('settings')->currencyUnit, null, log($scale, 10));
	}
}

<?php namespace App\Entities;

class Charge extends BaseEntity
{
	protected $table = 'charges';
	protected $casts = [
		'job_id'   => 'int',
		'price'    => 'int',
		'quantity' => '?float',
	];

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

		if (! empty($this->attributes['quantity']))
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

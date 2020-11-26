<?php namespace App\Entities;

class Charge extends BaseEntity
{
	protected $table = 'charges';
	protected $casts = [
		'ledger_id' => 'int',
		'price'     => 'int',
		'quantity'  => '?float',
	];

	/**
	 * Calculates the amount from the price and quantity.
	 *
	 * @param bool $formatted Whether to format the result for display, e.g. 1005 => $10.05
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

		helper(['currency', 'number']);
		return price_to_currency($amount);
	}
}

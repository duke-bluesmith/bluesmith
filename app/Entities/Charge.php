<?php

namespace App\Entities;

class Charge extends BaseEntity
{
	protected $table = 'charges';
	protected $casts = [
		'ledger_id' => 'int',
		'amount'    => 'int',
		'quantity'  => '?float',
	];

	/**
	 * Calculates the price from the amount and quantity.
	 *
	 * @param bool $formatted Whether to format the result for display, e.g. 1005 => $10.05
	 *
	 * @return int|string
	 */
	public function getPrice(bool $formatted = false)
	{
		$price = (int) $this->attributes['amount'];

		if (! empty($this->attributes['quantity']))
		{
			$price = round($price * (float) $this->attributes['quantity']);
		}

		if (! $formatted)
		{
			return (int) $price;
		}

		helper(['currency', 'number']);

		return price_to_currency($price);
	}
}

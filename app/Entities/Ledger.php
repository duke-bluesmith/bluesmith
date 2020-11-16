<?php namespace App\Entities;

class Ledger extends BaseEntity
{
	protected $table = 'ledgers';
	protected $casts = [
		'job_id'   => 'int',
		'estimate' => 'bool',
	];

	/**
	 * Default initial values
	 *
	 * @var array
	 */
	protected $attributes = [
		'description' => '',
		'estimate'    => 0,
	];

	/**
	 * Calculates the total amount from associated charges.
	 *
	 * @param bool $formatted Whether to format the result for display, e.g. 1005 => $10.05
	 *
	 * @return string|int
	 */
	public function getTotal(bool $formatted = false)
	{
		$total = 0;
		foreach ($this->charges ?? [] as $charge)
		{
			$total += $charge->amount;
		}

		if (! $formatted)
		{
			return $total;
		}

		helper(['currency', 'number']);
		return price_to_currency($total);
	}
}

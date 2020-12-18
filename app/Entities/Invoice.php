<?php namespace App\Entities;

/**
 * Invoice Entity
 *
 * An extension of a normal Ledger to include
 * convenience methods specific to Payments.
 */
class Invoice extends Ledger
{
	/**
	 * Store for calculated amount paid
	 *
	 * @var int|null
	 */
	private $paid;

	/**
	 * Calculates the total amount from associated Payments.
	 *
	 * @param bool $formatted Whether to format the result for display, e.g. 1005 => $10.05
	 *
	 * @return string|int
	 */
	public function getPaid(bool $formatted = false)
	{
		if (is_null($this->paid))
		{
			$this->paid = 0;
			foreach ($this->payments ?? [] as $payment)
			{
				if ($payment->code === 0)
				{
					$this->paid += $payment->amount;
				}
			}
		}

		if (! $formatted)
		{
			return $this->paid;
		}

		helper(['currency', 'number']);
		return price_to_currency($this->paid);
	}

	/**
	 * Calculates the due: total minus paid.
	 *
	 * @param bool $formatted Whether to format the result for display, e.g. 1005 => $10.05
	 *
	 * @return string|int
	 */
	public function getDue(bool $formatted = false)
	{
		$due = $this->getTotal() - $this->getPaid();

		if (! $formatted)
		{
			return $due;
		}

		helper(['currency', 'number']);
		return price_to_currency($due);
	}
}

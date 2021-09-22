<?php

namespace App\Entities;

/**
 * Payment Entity
 *
 * Represents a payment transaction record
 * with a merchant. Can be in varying states
 * as determined by `code`:
 *  - null : authorized but not processed
 *  - 0    : success
 *  - >0   : error, see `reason` or merchant docs for details
 */
class Payment extends BaseEntity
{
	protected $table = 'payments';
	protected $casts = [
		'ledger_id' => 'int',
		'user_id'   => 'int',
		'amount'    => 'int',
		'code'      => '?int',
	];

	/**
	 * Returns a user-friendly status string.
	 *
	 * @return string
	 */
	public function getStatus()
	{
		if (null === $this->attributes['code'])
		{
			return lang('Payment.pending');
		}

		if ($this->code === 0)
		{
			return lang('Payment.complete');
		}

		return $this->attributes['reason'] ?: lang('Payment.failure', [$this->attributes['code']]);
	}
}

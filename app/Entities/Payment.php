<?php namespace App\Entities;

/**
 * Payment Entity
 *
 * Represents a payment transaction record
 * with a merchant. Can be in varying states
 * as determined by `code`:
 *  - null : authorized but not processed
 *  - 0    : success
 *  - >0   : error, see Statuses or merchant docs for details
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
}

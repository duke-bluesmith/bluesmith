<?php namespace App\Entities;

class Payment extends BaseEntity
{
	protected $table = 'payments';
	protected $casts = [
		'ledger_id' => 'int',
		'user_id'   => 'int',
		'amount'    => 'int',
		'code'      => 'int',
	];
}

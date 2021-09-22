<?php

namespace App\Entities;

class Transaction extends BaseEntity
{
	protected $table = 'transactions';
	protected $casts = [
		'user_id' => 'int',
		'amount'  => 'int',
	];
}

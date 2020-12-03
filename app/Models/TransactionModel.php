<?php namespace App\Models;

use App\Entities\Transaction;

class TransactionModel extends BaseModel
{
	protected $table          = 'transactions';
	protected $returnType     = Transaction::class;
	protected $useSoftDeletes = false;
	protected $updatedField   = '';
	protected $allowedFields  = [
		'user_id', 'credit', 'amount', 'summary',
	];

	protected $validationRules = [
		'user_id' => 'required|is_natural_no_zero',
		'amount'  => 'required|is_natural_no_zero',
    ];
}

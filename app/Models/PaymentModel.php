<?php

namespace App\Models;

use App\Entities\Payment;

class PaymentModel extends BaseModel
{
	protected $table          = 'payments';
	protected $returnType     = Payment::class;
	protected $useSoftDeletes = false;
	protected $allowedFields  = [
		'ledger_id', 'user_id', 'amount',
		'class', 'reference', 'code', 'reason',
	];

	protected $validationRules = [
		'ledger_id' => 'required|is_natural_no_zero',
		'user_id'   => 'required|is_natural_no_zero',
		'amount'    => 'required|is_natural_no_zero',
		'class'     => 'required|string',
    ];
}

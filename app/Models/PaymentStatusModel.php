<?php namespace App\Models;

use App\Entities\PaymentStatus;

class PaymentStatusModel extends BaseModel
{
	protected $table          = 'payment_statuses';
	protected $returnType     = PaymentStatus::class;
	protected $allowedFields  = [
		'payment_id', 'code', 'reason', 'json',
	];

	protected $validationRules = [
		'payment_id' => 'required|is_natural_no_zero',
		'code'       => 'required|is_natural',
		'reason'     => 'required',
		'json'       => 'in_list[0,1]',
    ];
}

<?php namespace App\Models;

use App\Entities\Charge;

class ChargeModel extends BaseModel
{
	protected $table          = 'charges';
	protected $returnType     = Charge::class;
	protected $useSoftDeletes = false;
	protected $allowedFields  = [
		'ledger_id', 'name', 'price', 'quantity',
	];

	protected $validationRules = [
		'ledger_id' => 'required|is_natural_no_zero',
		'name'      => 'required',
		'price'     => 'permit_empty|integer',
		'quantity'  => 'permit_empty|greater_than[0]',
    ];
}

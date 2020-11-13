<?php namespace App\Models;

use App\Entities\Charge;

class ChargeModel extends BaseModel
{
	protected $table          = 'charges';
	protected $returnType     = Charge::class;
	protected $useSoftDeletes = false;
	protected $allowedFields  = [
		'invoice_id', 'job_id', 'name', 'price', 'quantity',
	];

	protected $validationRules = [
		'invoice_id' => 'if_exist|required_without[job_id]|is_natural_no_zero',
		'job_id'     => 'if_exist|required_without[invoice_id]|is_natural_no_zero',
		'name'       => 'required',
		'price'      => 'permit_empty|integer',
		'quantity'   => 'permit_empty|greater_than[0]',
    ];
}

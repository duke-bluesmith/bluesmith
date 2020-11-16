<?php namespace App\Models;

use App\Entities\Invoice;

class InvoiceModel extends BaseModel
{
	protected $table          = 'invoices';
	protected $returnType     = Invoice::class;
	protected $allowedFields  = [
		'job_id', 'description', 'estimate',
	];

	protected $validationRules = [
		'job_id' => 'required|is_natural_no_zero',
    ];
}

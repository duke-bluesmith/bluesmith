<?php

namespace App\Models;

use App\Entities\Ledger;

class LedgerModel extends BaseModel
{
    protected $table         = 'ledgers';
    protected $returnType    = Ledger::class;
    protected $allowedFields = [
        'job_id', 'description', 'estimate',
    ];

    protected $validationRules = [
        'job_id' => 'required|is_natural_no_zero',
    ];
}

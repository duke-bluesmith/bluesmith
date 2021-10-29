<?php

namespace App\Models;

use App\Entities\Charge;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

class ChargeModel extends BaseModel
{
    protected $table          = 'charges';
    protected $returnType     = Charge::class;
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'ledger_id', 'name', 'amount', 'quantity',
    ];
    protected $validationRules = [
        'ledger_id' => 'required|is_natural_no_zero',
        'name'      => 'required',
        'amount'    => 'permit_empty|integer',
        'quantity'  => 'permit_empty|greater_than[0]',
    ];

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): Charge
    {
        return new Charge([
            'ledger_id' => mt_rand(1, Fabricator::getCount('ledgers') ?: 10),
            'name'      => $faker->sentence,
            'amount'    => mt_rand(100, 10000),
            'quantity'  => mt_rand(0, 1) ? mt_rand(1, 5) : null,
        ]);
    }
}

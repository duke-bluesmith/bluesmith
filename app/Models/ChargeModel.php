<?php

namespace App\Models;

use App\Entities\Charge;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

/**
 * @psalm-suppress MethodSignatureMismatch
 */
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
            'ledger_id' => random_int(1, Fabricator::getCount('ledgers') ?: 10),
            'name'      => $faker->sentence,
            'amount'    => random_int(100, 10000),
            'quantity'  => random_int(0, 1) ? random_int(1, 5) : null,
        ]);
    }
}

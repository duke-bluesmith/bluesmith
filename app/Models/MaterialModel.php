<?php

namespace App\Models;

use App\Entities\Material;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

/**
 * @psalm-suppress MethodSignatureMismatch
 */
class MaterialModel extends BaseModel
{
    protected $table           = 'materials';
    protected $with            = ['methods'];
    protected $returnType      = Material::class;
    protected $allowedFields   = ['name', 'summary', 'description', 'cost', 'sortorder', 'method_id'];
    protected $validationRules = [
        'name'      => 'required',
        'method_id' => 'required|is_natural_no_zero',
        'cost'      => 'permit_empty|is_natural_no_zero',
    ];
    protected $withDeletedRelations = ['methods'];

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): Material
    {
        return new Material([
            'name'        => $faker->catchPhrase,
            'summary'     => $faker->sentence,
            'description' => $faker->paragraph,
            'cost'        => random_int(0, 4) ? random_int(100, 500) : null,
            'sortorder'   => random_int(1, 10),
            'method_id'   => random_int(1, Fabricator::getCount('methods') ?: 8),
        ]);
    }
}

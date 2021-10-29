<?php

namespace App\Models;

use App\Entities\Material;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

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

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): Material
    {
        return new Material([
            'name'        => $faker->catchPhrase,
            'summary'     => $faker->sentence,
            'description' => $faker->paragraph,
            'cost'        => mt_rand(0, 4) ? mt_rand(100, 500) : null,
            'sortorder'   => mt_rand(1, 10),
            'method_id'   => mt_rand(1, Fabricator::getCount('methods') ?: 8),
        ]);
    }
}

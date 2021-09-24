<?php

namespace App\Models;

use App\Entities\Method;
use Faker\Generator;

class MethodModel extends BaseModel
{
    protected $table         = 'methods';
    protected $returnType    = 'App\Entities\Method';
    protected $allowedFields = ['name', 'summary', 'description', 'sortorder'];

    protected $validationRules = [
        'name' => 'required',
    ];

    /**
     * Faked data for Fabricator.
     */
    public function fake(Generator &$faker): Method
    {
        return new Method([
            'name'        => $faker->catchPhrase,
            'summary'     => $faker->sentence,
            'description' => $faker->paragraph,
            'sortorder'   => mt_rand(1, 10),
        ]);
    }
}

<?php namespace App\Models;

use App\Entities\Material;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

class MaterialModel extends BaseModel
{
	protected $table         = 'materials';
	protected $with          = ['methods'];
	protected $returnType    = Material::class;
	protected $allowedFields = ['name', 'summary', 'description', 'cost', 'sortorder', 'method_id'];

	protected $validationRules = [
		'name'      => 'required',
		'method_id' => 'required|is_natural_no_zero',
		'cost'      => 'permit_empty|is_natural_no_zero',
	];

	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return Material
	 */
	public function fake(Generator &$faker): Material
	{
		return new Material([
			'name'        => $faker->catchPhrase,
			'summary'     => $faker->sentence,
			'description' => $faker->paragraph,
			'cost'        => rand(0, 4) ? rand(100, 500) : null,
			'sortorder'   => rand(1, 10),
			'method_id'   => rand(1, Fabricator::getCount('methods') ?: 8),
		]);
	}
}

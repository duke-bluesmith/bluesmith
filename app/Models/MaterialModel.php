<?php namespace App\Models;

use App\Entities\Material;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;

class MaterialModel extends BaseModel
{
	protected $table         = 'materials';
	protected $with          = ['methods'];
	protected $returnType    = 'App\Entities\Material';
	protected $allowedFields = ['name', 'summary', 'description', 'sortorder', 'method_id'];

	protected $validationRules = [
		'name'      => 'required',
		'method_id' => 'required|is_natural_no_zero',
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
			'sortorder'   => rand(1, 10),
			'method_id'   => rand(1, Fabricator::getCount('methods') ?: 8),
		]);
	}
}

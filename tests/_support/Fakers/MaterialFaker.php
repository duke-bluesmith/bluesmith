<?php namespace Tests\Support\Fakers;

use App\Entities\Material;
use App\Models\MaterialModel;
use Faker\Generator;
use Tests\Support\Simulator;

class MaterialFaker extends MaterialModel
{
	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return Material
	 */
	public function fake(Generator &$faker)
	{
		Simulator::$counts['materials']++;

		return new Material([
			'name'        => $faker->catchPhrase,
			'summary'     => $faker->sentence,
			'description' => $faker->paragraph,
			'sortorder'   => rand(1, 10),
			'method_id'   => rand(1, Simulator::$counts['methods'] ?? 8),
		]);
	}
}

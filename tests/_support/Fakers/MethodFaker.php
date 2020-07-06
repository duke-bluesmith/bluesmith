<?php namespace Tests\Support\Fakers;

use App\Entities\Method;
use App\Models\MethodModel;
use Faker\Generator;
use Tests\Support\Simulator;

class MethodFaker extends MethodModel
{
	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return Method
	 */
	public function fake(Generator &$faker): Method
	{
		return new Method([
			'name'        => $faker->catchPhrase,
			'summary'     => $faker->sentence,
			'description' => $faker->paragraph,
			'sortorder'   => rand(1, 10),
		]);
	}
}

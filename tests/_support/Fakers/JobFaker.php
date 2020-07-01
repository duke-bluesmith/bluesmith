<?php namespace Tests\Support\Fakers;

use Faker\Generator;
use Tatter\Workflows\Entities\Job;
use Tatter\Workflows\Models\JobModel;
use Tests\Support\Simulator;

class JobFaker extends JobModel
{
	/**
	 * Faked data for Fabricator.
	 *
	 * @param Generator $faker
	 *
	 * @return Job
	 */
	public function fake(Generator &$faker)
	{
		Simulator::$counts['jobs']++;

		return new Job([
			'name'        => $faker->catchPhrase,
			'summary'     => $faker->sentence,
			'workflow_id' => rand(1, Simulator::$counts['workflows'] ?: 4),
			'stage_id'    => rand(1, Simulator::$counts['stages']    ?: 99),
			'material_id' => rand(1, Simulator::$counts['materials'] ?: 35),
		]);
	}
}

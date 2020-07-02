<?php namespace Tests\Support;

use Tests\Support\Fakers\JobFaker;
use Tests\Support\Fakers\MaterialFaker;
use Tests\Support\Fakers\MethodFaker;
use Tests\Support\Fakers\UserFaker;

/**
 * Support class for simulating a complete project environment.
 */
class Simulator extends \Tatter\Workflows\Test\Simulator
{
	/**
	 * Whether initialize() has been run 
	 *
	 * @var array
	 */
	static public $initialized = false;

	/**
	 * Number of each object type created since last reset.
	 *
	 * @var array
	 */
	static public $counts = [
		'jobs'      => 0,
		'stages'    => 0,
		'actions'     => 0,
		'workflows' => 0,
		'methods'   => 0,
		'materials' => 0,
		'users'     => 0,
	];

	/**
	 * Initialize the simulation.
	 */
	static public function initialize()
	{
		parent::initialize();

		// Create methods up to N
		$count = rand(1, 8);
		while (self::$counts['methods'] < $count)
		{
			fake(MethodFaker::class);
		}

		// Create materials up to N
		$count = self::$counts['methods'] * rand(2, 6);
		while (self::$counts['materials'] < $count)
		{
			fake(MaterialFaker::class);
		}

		// Create users up to N
		$count = rand(20, 50);
		while (self::$counts['users'] < $count)
		{
			fake(UserFaker::class);
		}

		// Remake jobs with our faker
		self::$counts['jobs'] = 0;
		$count = rand(40, 200);
		while (self::$counts['jobs'] < $count)
		{
			fake(JobFaker::class);
		}

		// Assign jobs to users
		$builder = db_connect()->table('jobs_users');
		for ($i = 1; $i < self::$counts['jobs']; $i++)
		{
			$builder->insert([
				'job_id'  => $i,
				'user_id' => rand(1, self::$counts['users']),
			]);
		}

		// Make a few jobs have multiple users
		$count = rand(10, 30);
		for ($i = 1; $i < $count; $i++)
		{
			$user = fake(UserFaker::class);

			$builder->insert([
				'job_id'  => rand(1, self::$counts['jobs']),
				'user_id' => $user->id,
			]);		
		}

		self::$initialized = true;
	}

	/**
	 * Reset counts.
	 */
	static public function reset()
	{
		parent::reset();

		self::$initialized = false;
	}
}

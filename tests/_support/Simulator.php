<?php namespace Tests\Support;

use CodeIgniter\Test\Fabricator;
use Myth\Auth\Authorization\GroupModel;
use Tatter\Workflows\Test\Simulator as BaseSimulator;
use Tests\Support\Fakers\JobFaker;
use Tests\Support\Fakers\MaterialFaker;
use Tests\Support\Fakers\MethodFaker;
use Tests\Support\Fakers\UserFaker;

/**
 * Support class for simulating a complete project environment.
 * Builds off existing funcitonality in Workflows.
 */
class Simulator extends BaseSimulator
{
	/**
	 * Initialize the simulation.
	 *
	 * @param array $targets  Array of target items to create
	 */
	static public function initialize($targets = ['actions', 'jobs', 'materials', 'methods', 'stages', 'users', 'workflows'])
	{
		parent::initialize(array_intersect(['actions', 'stages', 'workflows'], $targets));

		// Create methods up to N
		if (in_array('methods', $targets))
		{
			$count = rand(1, 2);
			while (Fabricator::getCount('methods') < $count)
			{
				fake(MethodFaker::class);
			}
		}

		// Create materials up to N
		if (in_array('materials', $targets))
		{
			$count = Fabricator::getCount('methods') * rand(2, 4);
			while (Fabricator::getCount('materials') < $count)
			{
				fake(MaterialFaker::class);
			}
		}

		// Create users up to N
		if (in_array('users', $targets))
		{
			$count = rand(3, 5);
			while (Fabricator::getCount('users') < $count)
			{
				fake(UserFaker::class);
			}

			// Assign some users to groups (created by AuthSeeder)
			$numGroups = model(GroupModel::class)->countAllResults();

			$count = rand(5, 10);
			for ($i = 1; $i < $count; $i++)
			{
				model(GroupModel::class)->addUserToGroup(
					rand(1, Fabricator::getCount('users')),
					$i % $numGroups + 1 // Ensures every group gets at least one
				);
			}			
		}

		// Create jobs up to N
		if (in_array('jobs', $targets))
		{
			$count = rand(4, 20);
			while (Fabricator::getCount('jobs') < $count)
			{
				fake(JobFaker::class);
			}

			// Assign jobs to users
			$builder = db_connect()->table('jobs_users');
			for ($i = 1; $i < Fabricator::getCount('jobs'); $i++)
			{
				$builder->insert([
					'job_id'  => $i,
					'user_id' => rand(1, Fabricator::getCount('users')),
				]);
			}

			// Make a few jobs have multiple users
			$count = rand(2, 6);
			for ($i = 1; $i < $count; $i++)
			{
				$user = fake(UserFaker::class);

				$builder->insert([
					'job_id'  => rand(1, Fabricator::getCount('jobs')),
					'user_id' => $user->id,
				]);		
			}
		}
	}
}

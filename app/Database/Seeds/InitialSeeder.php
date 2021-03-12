<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tatter\Files\Database\Seeds\FileSeeder;
use Tatter\Settings\Database\Seeds\SettingsSeeder;
use Tatter\Workflows\Registrar;

class InitialSeeder extends Seeder
{
	public function run()
	{
		$errors = [];

		// Seeds to run
		$seeds = [
			SettingsSeeder::class,
			FileSeeder::class,
			AuthSeeder::class,
			EmailSeeder::class,
			OptionSeeder::class,
			PageSeeder::class,
			ThemeSeeder::class,
			WorkflowSeeder::class,
		];

		// Check for a Local seeder
		if (class_exists($seedName = 'Local\Database\Seeds\LocalSeeder'))
		{
			$seeds[] = $seedName; // @codeCoverageIgnore
		}

		// Run each seeder in order
		foreach ($seeds as $seedName)
		{
			try
			{
				$this->call($seedName);
			}
			// @codeCoverageIgnoreStart
			catch (\Exception $e)
			{
				// Pass CLI exceptions back to BaseCommand for display
				if (is_cli())
				{
					throw $e;
				}
				else
				{
					$errors[] = $e->getFile() . ' - ' . $e->getLine() . ': ' . $e->getMessage() . " (for {$seedName})";
				}
			}
			// @codeCoverageIgnoreEnd
		}

		// Use the Registrar to seed Actions
		if (Registrar::actions() && ENVIRONMENT !== 'testing')
		{
			command('actions:list'); // @codeCoverageIgnore
		}

		return $errors;
	}
}

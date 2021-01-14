<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Tatter\Workflows\Registrar;

class InitialSeeder extends Seeder
{
	public function run()
	{
		$errors = [];

		// Seeds to run
		$seeds = [
			'Tatter\Settings\Database\Seeds\SettingsSeeder',
			'Tatter\Files\Database\Seeds\FileSeeder',
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
			$seeds[] = $seedName;
		}

		// Run each seeder in order
		foreach ($seeds as $seedName)
		{
			try
			{
				$this->call($seedName);
			}
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
		}

		// Use the Registrar to seed Actions
		if (Registrar::actions())
		{
			command('actions:list');
		}

		return $errors;
	}
}

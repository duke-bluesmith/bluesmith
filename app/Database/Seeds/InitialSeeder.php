<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
	public function run()
	{
		$errors = [];

		// Seeds to run
		$seeds = [
			'Tatter\Settings\Database\Seeds\SettingsSeeder',
			'Tatter\Themes\Database\Seeds\ThemeSeeder',
			'Tatter\Files\Database\Seeds\FileSeeder',
			'App\Database\Seeds\AuthSeeder',
			'App\Database\Seeds\EmailSeeder',
			'App\Database\Seeds\PageSeeder',
			'App\Database\Seeds\OptionSeeder',
			'App\Database\Seeds\WorkflowSeeder',
		];

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
		
		return $errors;
	}
}

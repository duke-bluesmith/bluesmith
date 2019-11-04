<?php namespace ProjectTests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder extends Seeder
{
	public function run()
	{
		if (ENVIRONMENT != 'testing'):
			CLI::write('ERROR: Must be run in testing environment', 'red');
			throw new \Exception('Environment exception');
		endif;
		
		// Seed from App
		$this->setPath(APPPATH . 'Database/Seeds');
		$seeders = ['AuthSeeder', 'OptionSeeder'];
		foreach ($seeders as $seeder)
		{
			$this->call($seeder);
		}
	}
}

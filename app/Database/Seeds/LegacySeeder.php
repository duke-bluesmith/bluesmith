<?php namespace App\Database\Seeds;

use App\Models\Legacy\MaterialModel;
use App\Models\Legacy\MethodModel;

class LegacySeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// Setup
		$db     = db_connect();
		$legacy = db_connect('legacy');
		
		$db->disableForeignKeyChecks();
		
		/* METHODS & MATERIALS */
		$legacyMaterials = new MaterialModel();
		$legacyMethods   = new MethodModel();
		
		// Truncate
		$db->table('methods')->truncate();
		$db->table('materials')->truncate();

		// Port data row by row
		foreach ($legacyMethods->findAll() as $legacyMethod)
		{
			$legacyMethods->legacyToLive($legacyMethod);
		}
		foreach ($legacyMaterials->findAll() as $legacyMaterial)
		{
			$legacyMaterials->legacyToLive($legacyMaterial);
		}
		
		// Cleanup
		$db->enableForeignKeyChecks();
	}
}

		
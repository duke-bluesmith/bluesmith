<?php namespace App\Database\Seeds;

use \App\Models\MethodModel;

class LegacySeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		$db     = db_connect();
		$legacy = db_connect('legacy');
		
		/* METHODS & MATERIALS */
		$methods = new MethodModel();
		
		// Truncate
		$db->table('methods')->truncate();
		$db->table('materials')->truncate();
		
		// Load previous data
		$query = $legacy->table('methods')->get();
		foreach ($query->getResult() as $row)
		{
			$method = [
				'id'          => $row->id,
				'name'        => $row->name,
				'summary'     => $row->fullname,
				'description' => $row->description,
				'sortorder'   => $row->sortorder,
				'created_at'  => $row->created_at,
				'updated_at'  => $row->updated_at,
				'deleted_at'  => $row->status == 'Archived' ? $row->updated_at : null,
			];
			
			$methods->insert($method);
		}
	}
}

		
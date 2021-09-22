<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterJobs extends Migration
{
	public function up()
	{
		$fields = [
			'material_id' => ['type' => 'int', 'unsigned' => true, null => 'true', 'after' => 'stage_id'],
		];

		$this->forge->addColumn('jobs', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('jobs', 'material_id');
	}
}

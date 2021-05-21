<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImplementVolume extends Migration
{
	public function up()
	{
		$this->forge->addColumn('files', [
			'volume' => ['type' => 'double', 'after' => 'thumbnail', 'null' => true],
		]);

		$this->forge->addColumn('materials', [
			'cost' => ['type' => 'int', 'after' => 'description', 'null' => true],
		]);

	}

	public function down()
	{
		$this->forge->dropColumn('materials', 'cost');
		$this->forge->dropColumn('files', 'volume');
	}
}

<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsers extends Migration
{
	public function up()
	{
		$fields = [
			'firstname' => ['type' => 'varchar', 'constraint' => 255, 'after' => 'username'],
			'lastname'  => ['type' => 'varchar', 'constraint' => 255, 'after' => 'firstname'],
		];

		$this->forge->addColumn('users', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('users', 'firstname');
		$this->forge->dropColumn('users', 'lastname');
	}
}

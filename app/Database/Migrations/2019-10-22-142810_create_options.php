<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOptions extends Migration
{
	public function up()
	{
		$fields = [
			'name'        => ['type' => 'varchar', 'constraint' => 127],
			'summary'     => ['type' => 'varchar', 'constraint' => 127, 'default' => ''],
			'description' => ['type' => 'varchar', 'constraint' => 255, 'default' => ''],
			'created_at'  => ['type' => 'datetime', 'null' => true],
			'updated_at'  => ['type' => 'datetime', 'null' => true],
			'deleted_at'  => ['type' => 'datetime', 'null' => true],
		];

		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey('name');
		$this->forge->addKey('created_at');

		$this->forge->createTable('options');

		// Add the jobs pivot table
		// jobs_options
		$fields = [
			'job_id'     => ['type' => 'int', 'unsigned' => true],
			'option_id'  => ['type' => 'int', 'unsigned' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
		];

		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['job_id', 'option_id']);
		$this->forge->addUniqueKey(['option_id', 'job_id']);

		$this->forge->createTable('jobs_options');
	}

	public function down()
	{
		$this->forge->dropTable('options');
		$this->forge->dropTable('jobs_options');
	}
}

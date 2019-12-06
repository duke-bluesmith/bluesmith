<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccepts extends Migration
{
	public function up()
	{
		// TOS acceptances
		$fields = [
			'job_id'     => ['type' => 'int', 'unsigned' => true],
			'user_id'    => ['type' => 'int', 'unsigned' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey(['job_id', 'user_id']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('accepts');
	}

	public function down()
	{
		$this->forge->dropTable('accepts');
	}
}

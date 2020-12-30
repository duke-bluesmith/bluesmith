<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJobsUsers extends Migration
{
	public function up()
	{
		// Add the pivot table
		// jobs_users
		$fields = [
			'job_id'     => ['type' => 'int', 'unsigned' => true],
			'user_id'    => ['type' => 'int', 'unsigned' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['job_id', 'user_id']);
		$this->forge->addUniqueKey(['user_id', 'job_id']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('jobs_users');
		
		// Invites
		$fields = [
			'job_id'     => ['type' => 'int', 'unsigned' => true],
			'issuer'     => ['type' => 'int', 'unsigned' => true, 'null' => true],
			'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'expired_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('job_id');
		$this->forge->addKey('email');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('invites');
	}

	public function down()
	{
		$this->forge->dropTable('jobs_users');
		$this->forge->dropTable('invites');
	}
}

<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_files extends Migration
{
	public function up()
	{
		// files
		$fields = [
			'name'          => ['type' => 'VARCHAR', 'constraint' => 31],
			'clientname'    => ['type' => 'VARCHAR', 'constraint' => 31],
			'filename'      => ['type' => 'VARCHAR', 'constraint' => 31],
			'type'          => ['type' => 'VARCHAR', 'constraint' => 31],
			'size'          => ['type' => 'FLOAT'],
			'created_at'    => ['type' => 'DATETIME', 'null' => true],
			'updated_at'    => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey('name');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('files');
		
		/*** Pivot tables ***/
		// files_jobs
		$fields = [
			'file_id'       => ['type' => 'INT', 'unsigned' => true],
			'job_id'        => ['type' => 'INT', 'unsigned' => true],
			'created_at'    => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['file_id', 'job_id']);
		$this->forge->addUniqueKey(['job_id', 'file_id']);
		
		$this->forge->createTable('files_jobs');
		
		// files_users
		$fields = [
			'file_id'       => ['type' => 'INT', 'unsigned' => true],
			'user_id'       => ['type' => 'INT', 'unsigned' => true],
			'created_at'    => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['file_id', 'user_id']);
		$this->forge->addUniqueKey(['user_id', 'file_id']);
		
		$this->forge->createTable('files_users');
		
		// downloads
		$fields = [
			'file_id'       => ['type' => 'INT', 'unsigned' => true],
			'user_id'       => ['type' => 'INT', 'unsigned' => true],
			'created_at'    => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey(['file_id', 'user_id']);
		$this->forge->addKey(['user_id', 'file_id']);
		
		$this->forge->createTable('downloads');
	}

	public function down()
	{
		$this->forge->dropTable('files');
		
		$this->forge->dropTable('files_jobs');
		$this->forge->dropTable('files_users');
		$this->forge->dropTable('downloads');
	}
}

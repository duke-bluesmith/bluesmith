<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_files_jobs extends Migration
{
	public function up()
	{
		// Add the jobs pivot table
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
	}

	public function down()
	{
		$this->forge->dropTable('files_jobs');
	}
}

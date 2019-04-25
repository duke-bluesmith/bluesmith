<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_jobs extends Migration
{
	public function up()
	{
		// add stage changes pivot
		$fields = [
			'job_id'         => ['type' => 'int', 'unsigned' => true],
			'from'           => ['type' => 'int', 'unsigned' => true],
			'to'             => ['type' => 'int', 'unsigned' => true],
			'created_by'     => ['type' => 'int', 'unsigned' => true],
			'created_at'     => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['stage_id', 'workflow_id']);
		$this->forge->addUniqueKey(['workflow_id', 'stage_id']);
		
		$this->forge->createTable('jobs_stages');
		
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}

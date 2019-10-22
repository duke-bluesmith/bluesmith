<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Models\Manage\PageModel;

class CreateOptions extends Migration
{
	public function up()
	{
		$fields = [
			'name'        => ['type' => 'VARCHAR', 'constraint' => 31],
			'summary'     => ['type' => 'VARCHAR', 'constraint' => 63],
			'description' => ['type' => 'VARCHAR', 'constraint' => 255],
			'created_at'  => ['type' => 'DATETIME', 'null' => true],
			'updated_at'  => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey('name');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('options');
		
		// Add the jobs pivot table
		// jobs_options
		$fields = [
			'job_id'     => ['type' => 'INT', 'unsigned' => true],
			'option_id'  => ['type' => 'INT', 'unsigned' => true],
			'created_at' => ['type' => 'DATETIME', 'null' => true],
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

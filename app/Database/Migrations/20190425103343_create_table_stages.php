<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_stages extends Migration
{
	public function up()
	{
		$fields = [
			'type'           => ['type' => 'varchar', 'constraint' => 31],
			'name'           => ['type' => 'varchar', 'constraint' => 31],
			'uid'            => ['type' => 'varchar', 'constraint' => 31],
			'route'          => ['type' => 'varchar', 'constraint' => 31],
			'party'          => ['type' => 'varchar', 'constraint' => 31],
			'icon'           => ['type' => 'varchar', 'constraint' => 31],
			'summary'        => ['type' => 'varchar', 'constraint' => 255],
			'description'    => ['type' => 'text'],
			'deleted'        => ['type' => 'boolean', 'default' => 0],
			'created_at'     => ['type' => 'datetime', 'null' => true],
			'updated_at'     => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey('uid');
		$this->forge->addKey(['type', 'name']);
		$this->forge->addKey(['deleted', 'id']);
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('stages');
		
		// add workflows pivot table
		$fields = [
			'stage_id'       => ['type' => 'int', 'unsigned' => true],
			'workflow_id'    => ['type' => 'int', 'unsigned' => true],
			'created_by'     => ['type' => 'int', 'unsigned' => true],
			'created_at'     => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['stage_id', 'workflow_id']);
		$this->forge->addUniqueKey(['workflow_id', 'stage_id']);
		
		$this->forge->createTable('stages_workflows');
	}

	public function down()
	{
		$this->forge->dropTable('stages');
		$this->forge->dropTable('stages_workflows');
	}
}

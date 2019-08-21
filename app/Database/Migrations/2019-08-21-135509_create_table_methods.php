<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_methods extends Migration
{
	public function up()
	{
		// Methods
		$fields = [
			'name'        => ['type' => 'VARCHAR', 'constraint' => 31],
			'summary'     => ['type' => 'VARCHAR', 'constraint' => 31],
			'description' => ['type' => 'TEXT'],
			'sortorder'   => ['type' => 'INT', 'unsigned' => true],
			'created_at'  => ['type' => 'DATETIME', 'null' => true],
			'updated_at'  => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey(['sortorder', 'name']);
		$this->forge->addKey('created_at');
		$this->forge->addKey('deleted_at');
		
		$this->forge->createTable('methods');
		
		// Materials
		$fields = [
			'name'        => ['type' => 'VARCHAR', 'constraint' => 31],
			'summary'     => ['type' => 'VARCHAR', 'constraint' => 31],
			'description' => ['type' => 'TEXT'],
			'sortorder'   => ['type' => 'INT', 'unsigned' => true],
			'method_id'   => ['type' => 'INT'],
			'created_at'  => ['type' => 'DATETIME', 'null' => true],
			'updated_at'  => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey(['sortorder', 'name']);
		$this->forge->addKey('created_at');
		$this->forge->addKey('deleted_at');
        $this->forge->addForeignKey('method_id', 'methods', 'id', false, 'CASCADE');
		
		$this->forge->createTable('materials');
	}

	public function down()
	{
		$this->db->disableForeignKeyConstraints();

		$this->forge->dropTable('materials');
		$this->forge->dropTable('methods');

		$this->db->enableForeignKeyConstraints();
	}
}

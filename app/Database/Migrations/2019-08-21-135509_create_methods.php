<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMethods extends Migration
{
	public function up()
	{
		// Methods
		$fields = [
			'name'        => ['type' => 'varchar', 'constraint' => 127],
			'summary'     => ['type' => 'varchar', 'constraint' => 127, 'default' => ''],
			'description' => ['type' => 'text', 'default' => ''],
			'sortorder'   => ['type' => 'int', 'unsigned' => true, 'default' => 0],
			'created_at'  => ['type' => 'datetime', 'null' => true],
			'updated_at'  => ['type' => 'datetime', 'null' => true],
			'deleted_at'  => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey(['sortorder', 'name']);
		$this->forge->addKey('created_at');
		$this->forge->addKey(['deleted_at', 'id']);
		
		$this->forge->createTable('methods');
		
		// Materials
		$fields = [
			'name'        => ['type' => 'varchar', 'constraint' => 127],
			'summary'     => ['type' => 'varchar', 'constraint' => 127, 'default' => ''],
			'description' => ['type' => 'text', 'default' => ''],
			'sortorder'   => ['type' => 'int', 'unsigned' => true, 'default' => 0],
			'method_id'   => ['type' => 'int'],
			'created_at'  => ['type' => 'datetime', 'null' => true],
			'updated_at'  => ['type' => 'datetime', 'null' => true],
			'deleted_at'  => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey(['sortorder', 'name']);
		$this->forge->addKey('created_at');
		$this->forge->addKey(['deleted_at', 'id']);
		
		$this->forge->createTable('materials');
	}

	public function down()
	{
		$this->forge->dropTable('materials');
		$this->forge->dropTable('methods');
	}
}

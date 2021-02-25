<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLedgers extends Migration
{
	public function up()
	{
		// Ledgers
		$fields = [
			'job_id'      => ['type' => 'int', 'unsigned' => true],
			'description' => ['type' => 'text', 'default' => ''],
			'estimate'    => ['type' => 'bool', 'default' => 0],
			'created_at'  => ['type' => 'datetime', 'null' => true],
			'updated_at'  => ['type' => 'datetime', 'null' => true],
			'deleted_at'  => ['type' => 'datetime', 'null' => true],
		];

		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('job_id');
		$this->forge->addKey('created_at');
		$this->forge->addKey(['deleted_at', 'id']);

		$this->forge->createTable('ledgers');

		// Charges
		$fields = [
			'ledger_id'  => ['type' => 'int', 'unsigned' => true],
			'name'       => ['type' => 'varchar', 'constraint' => 255],
			'amount'     => ['type' => 'int', 'default' => 0],
			'quantity'   => ['type' => 'double', 'null' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('ledger_id');
		$this->forge->addKey('created_at');
		$this->forge->addKey(['deleted_at', 'id']);
		
		$this->forge->createTable('charges');

		// Payments
		$fields = [
			'ledger_id'  => ['type' => 'int', 'unsigned' => true],
			'user_id'    => ['type' => 'int', 'unsigned' => true],
			'amount'     => ['type' => 'int'],
			'class'      => ['type' => 'varchar', 'constraint' => 255],
			'reference'  => ['type' => 'varchar', 'constraint' => 255, 'default' => ''],
			'code'       => ['type' => 'int', 'null' => true],
			'reason'     => ['type' => 'text', 'default' => ''],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('ledger_id');
		$this->forge->addKey('user_id');
		$this->forge->addKey('reference');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('payments');
	}

	public function down()
	{
		$this->forge->dropTable('payments');
		$this->forge->dropTable('charges');
		$this->forge->dropTable('ledgers');
	}
}

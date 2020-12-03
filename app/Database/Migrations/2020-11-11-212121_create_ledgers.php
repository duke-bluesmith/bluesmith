<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLedgers extends Migration
{
	public function up()
	{
		// Ledgers
		$fields = [
			'job_id'      => ['type' => 'int', 'unsigned' => true],
			'description' => ['type' => 'text', 'null' => false, 'default' => ''],
			'estimate'    => ['type' => 'bool', 'null' => false, 'default' => 0],
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
			'amount'     => ['type' => 'int', 'null' => false, 'default' => 0],
			'quantity'   => ['type' => 'double', 'null' => true, 'default' => null],
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
			'amount'     => ['type' => 'int', 'null' => false, 'default' => 0],
			'class'      => ['type' => 'varchar', 'constraint' => 255],
			'reference'  => ['type' => 'varchar', 'constraint' => 255],
			'code'       => ['type' => 'int', 'null' => false, 'default' => 0],
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

		// Payment statuses
		$fields = [
			'payment_id' => ['type' => 'int', 'unsigned' => true],
			'code'       => ['type' => 'int', 'null' => false, 'default' => 0],
			'reason'     => ['type' => 'text', 'null' => false, 'default' => ''],
			'json'       => ['type' => 'bool', 'null' => false, 'default' => 0],
			'created_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('payment_id');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('payment_statuses');
	}

	public function down()
	{
		$this->forge->dropTable('payment_statuses');
		$this->forge->dropTable('payments');
		$this->forge->dropTable('charges');
		$this->forge->dropTable('ledgers');
	}
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Transactions Migration
 *
 * Transactions are records of charges and credits
 * to Bluesmith's internal currency (usually termed
 * "Bluechips"). They repesent an alternate payment
 * method to using external payment gateways and can
 * be thought of as "store credit".
 * Transactions should not be confused with Payments,
 * which are independent of any particular gateway.
 */
class CreateTransactions extends Migration
{
	public function up()
	{
		// Internal transactions (Bluechips)
		$fields = [
			'user_id'    => ['type' => 'int', 'unsigned' => true],
			'credit'     => ['type' => 'bool', 'null' => false, 'default' => 0],
			'amount'     => ['type' => 'int', 'null' => false],
			'summary'    => ['type' => 'varchar', 'constraint' => 255, 'default' => ''],
			'created_at' => ['type' => 'datetime', 'null' => true],
		];

		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('user_id');
		$this->forge->addKey('created_at');

		$this->forge->createTable('transactions');

		// User balances
		$fields = [
			'balance' => ['type' => 'int', 'null' => false, 'default' => 0, 'after' => 'lastname'],
		];

		$this->forge->addColumn('users', $fields);
	}

	public function down()
	{
		$this->forge->dropTable('transactions');
		$this->forge->dropColumn('users', 'balance');
	}
}

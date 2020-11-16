<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoices extends Migration
{
	public function up()
	{
		// Invoices
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

		$this->forge->createTable('invoices');

		// Charges
		$fields = [
			'invoice_id' => ['type' => 'int', 'unsigned' => true],
			'name'       => ['type' => 'varchar', 'constraint' => 255],
			'price'      => ['type' => 'int', 'null' => false, 'default' => 0],
			'quantity'   => ['type' => 'double', 'null' => true],
			'created_at' => ['type' => 'datetime', 'null' => true],
			'updated_at' => ['type' => 'datetime', 'null' => true],
			'deleted_at' => ['type' => 'datetime', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('invoice_id');
		$this->forge->addKey('created_at');
		$this->forge->addKey(['deleted_at', 'id']);
		
		$this->forge->createTable('charges');
	}

	public function down()
	{
		$this->forge->dropTable('charges');
		$this->forge->dropTable('invoices');
	}
}

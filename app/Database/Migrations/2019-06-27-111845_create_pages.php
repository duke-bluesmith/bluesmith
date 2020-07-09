<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Models\Manage\PageModel;

class CreatePages extends Migration
{
	public function up()
	{
		$fields = [
			'name'          => ['type' => 'VARCHAR', 'constraint' => 127],
			'content'       => ['type' => 'TEXT'],
			'created_at'    => ['type' => 'DATETIME', 'null' => true],
			'updated_at'    => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey('name');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('pages');
	}

	public function down()
	{
		$this->forge->dropTable('pages');
	}
}

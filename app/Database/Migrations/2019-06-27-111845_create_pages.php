<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Models\Manage\PageModel;

class CreatePages extends Migration
{
	public function up()
	{
		$fields = [
			'name'          => ['type' => 'varchar', 'constraint' => 127],
			'content'       => ['type' => 'text'],
			'created_at'    => ['type' => 'datetime', 'null' => true],
			'updated_at'    => ['type' => 'datetime', 'null' => true],
			'deleted_at'    => ['type' => 'datetime', 'null' => true],
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

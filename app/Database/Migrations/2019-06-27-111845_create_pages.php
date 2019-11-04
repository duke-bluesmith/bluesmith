<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Models\Manage\PageModel;

class CreatePages extends Migration
{
	public function up()
	{
		$fields = [
			'name'          => ['type' => 'VARCHAR', 'constraint' => 31],
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
		
		// Add rows for required pages
		$pages = new PageModel();
		foreach (['Home', 'Options'] as $name):
			$row = [
				'name'    => $name,
				'content' => view("_examples/{$name}", [], ['debug' => false]),
			];
			$pages->insert($row);
		endforeach;
	}

	public function down()
	{
		$this->forge->dropTable('pages');
	}
}

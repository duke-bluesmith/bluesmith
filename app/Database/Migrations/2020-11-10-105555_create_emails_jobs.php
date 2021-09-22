<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailsJobs extends Migration
{
	public function up()
	{
		// Add the pivot table
		// emails_jobs
		$fields = [
			'email_id' => ['type' => 'int', 'unsigned' => true],
			'job_id'   => ['type' => 'int', 'unsigned' => true],
		];

		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addUniqueKey(['email_id', 'job_id']);
		$this->forge->addUniqueKey(['job_id', 'email_id']);

		$this->forge->createTable('emails_jobs');
	}

	public function down()
	{
		$this->forge->dropTable('emails_jobs');
	}
}

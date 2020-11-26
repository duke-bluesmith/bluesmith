<?php namespace App\Entities;

use App\Entities\Note;
use CodeIgniter\Test\CIUnitTestCase;

class NoteTest extends CIUnitTestCase
{
	public function testGetContentUnformatted()
	{
		$note = new Note([
			'job_id'  => 1,
			'user_id' => 1,
			'content' => 'Test **markup**',
		]);

		$this->assertEquals('Test **markup**', $note->getContent(false));
	}

	public function testGetContentFormatted()
	{
		$note = new Note([
			'job_id'  => 1,
			'user_id' => 1,
			'content' => 'Test **markup**',
		]);

		$this->assertEquals("<p>Test <strong>markup</strong></p>\n", $note->getContent(true));
	}
}

<?php namespace App\Entities;

use App\Entities\Note;
use Tests\Support\ProjectTestCase;

class NoteTest extends ProjectTestCase
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

<?php

namespace App\Entities;

use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class NoteTest extends ProjectTestCase
{
    public function testGetContentUnformatted()
    {
        $note = new Note([
            'job_id'  => 1,
            'user_id' => 1,
            'content' => 'Test **markup**',
        ]);

        $this->assertSame('Test **markup**', $note->getContent(false));
    }

    public function testGetContentFormatted()
    {
        $note = new Note([
            'job_id'  => 1,
            'user_id' => 1,
            'content' => 'Test **markup**',
        ]);

        $this->assertSame("<p>Test <strong>markup</strong></p>\n", $note->getContent(true));
    }
}

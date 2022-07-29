<?php

namespace App\Publishers;

use Tatter\Frontend\Test\PublishersTestCase;

/**
 * @internal
 */
final class PublishersTest extends PublishersTestCase
{
    public function publisherProvider(): array
    {
        return [
            [
                TinyMCEPublisher::class,
                [
                    'tinymce/tinymce.min.js',
                    'tinymce/icons/default/icons.min.js',
                ],
            ],
        ];
    }
}

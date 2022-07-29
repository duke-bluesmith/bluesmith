<?php

namespace App\Bundles;

use Tatter\Assets\Test\BundlesTestCase;

/**
 * @internal
 */
final class BundlesTest extends BundlesTestCase
{
    public function bundleProvider(): array
    {
        return [
            [
                TinyMCEBundle::class,
                [],
                [
                    'tinymce.min.js',
                ],
            ],
        ];
    }
}

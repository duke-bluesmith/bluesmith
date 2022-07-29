<?php

namespace App\Bundles;

use Tatter\Assets\Asset;
use Tatter\Frontend\FrontendBundle;

class TinyMCEBundle extends FrontendBundle
{
    /**
     * Applies any initial inputs after the constructor.
     */
    protected function define(): void
    {
        // TinyMCE needs to load early so we create the Asset then move it to the head tag
        $asset = Asset::createFromPath(Asset::config()->vendor . 'tinymce/tinymce.min.js');

        $this->add(new Asset($asset, true));
    }
}

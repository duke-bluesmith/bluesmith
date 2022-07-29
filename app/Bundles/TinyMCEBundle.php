<?php

namespace App\Bundles;

use Tatter\Frontend\FrontendBundle;

class TinyMCEBundle extends FrontendBundle
{
    /**
     * Applies any initial inputs after the constructor.
     */
    protected function define(): void
    {
        $this->addPath('tinymce/tinymce.min.js');
    }
}

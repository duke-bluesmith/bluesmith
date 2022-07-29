<?php

namespace App\Publishers;

use Tatter\Frontend\FrontendPublisher;

class TinyMCEPublisher extends FrontendPublisher
{
    protected string $vendorPath = 'tinymce/tinymce';
    protected string $publicPath = 'tinymce';

    /**
     * Reads files from the sources and copies them out to their destinations.
     * This method should be reimplemented by child classes intended for
     * discovery.
     */
    public function publish(): bool
    {
        return $this
            ->addPath('/', false)
            ->addPath('icons')
            ->addPath('plugins')
            ->addPath('skins')
            ->addPath('themes')
            ->retainPattern('*.js')
            ->merge(true);
    }
}

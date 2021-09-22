<?php

namespace App\Exports;

use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Exports\BaseExport;

class STLHandler extends BaseExport
{
    /**
     * Attributes for Tatter\Handlers
     *
     * @var array<string, mixed>
     */
    public $attributes = [
        'name'       => 'Preview',
        'slug'       => 'stl',
        'icon'       => 'fas fa-cube',
        'summary'    => 'Preview a 3D model in the browser',
        'extensions' => 'stl',
        'ajax'       => false,
        'direct'     => true,
        'bulk'       => false,
    ];

    /**
     * Checks for AJAX to tag image, otherwise reads out the file directly.
     */
    protected function _process(): ?ResponseInterface
    {
        //		log_message('debug', print_r($this->request->headers(), true));

        // If the Referer is the export page than this is the ThreeJS request for the file
        return $this->request->hasHeader('Referer') && strpos($this->request->getHeaderLine('Referer'), 'export/stl')
            ? $this->processFile()
            : $this->processDisplay();
    }

    /**
     * Creates the ThreeJS view.
     */
    protected function processDisplay(): ResponseInterface
    {
        $file = $this->getFile();
        $path = $file->getRealPath() ?: (string) $file;

        return $this->response->setBody(view('layouts/threejs', [
            'id'   => $this->request->getUri()->getSegment(4),
            'file' => $file,
        ]));
    }

    /**
     * Reads the file out directly to browser.
     */
    protected function processFile(): ResponseInterface
    {
        $file = $this->getFile();
        $path = $file->getRealPath() ?: (string) $file;

        // Set the headers and read out the file
        return $this->response
            ->setHeader('Content-Type', $this->fileMime)
            ->setBody(file_get_contents($path));
    }
}

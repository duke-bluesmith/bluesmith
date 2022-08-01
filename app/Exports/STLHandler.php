<?php

namespace App\Exports;

use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Exports\BaseExporter;

class STLHandler extends BaseExporter
{
    public const HANDLER_ID = 'stl';

    protected static function getAttributes(): array
    {
        return [
            'name'       => 'Preview',
            'icon'       => 'fas fa-cube',
            'summary'    => 'Preview a 3D model in the browser',
            'ajax'       => false,
            'direct'     => true,
            'bulk'       => false,
            'extensions' => ['stl'],
        ];
    }

    protected function doProcess(): ResponseInterface
    {
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
        return $this->response->setBody(view('layouts/threejs', [
            'id'   => $this->request->getUri()->getSegment(4),
            'file' => $this->getFile(),
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

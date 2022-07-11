<?php

namespace Config;

use App\Entities\Job;
use App\Models\JobModel;
use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use PHPSTL\Exceptions\InvalidFileFormatException;
use PHPSTL\Handler\VolumeHandler;
use PHPSTL\Reader\STLReader;
use Tatter\Files\Entities\File;
use Tatter\Files\Models\FileModel;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function () {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }
});

/**
 * Loads helpers we want available globally.
 *
 * @see BaseAction::__construct() and BaseController::$helpers for slightly less global
 */
Events::on('post_controller_constructor', static function () {
    helper(['alerts', 'auth', 'html']);
});

/**
 * Captures uploads from FilesController to associate with
 * a Job and process volume on relevant files.
 */
Events::on('upload', static function (File $file) {

    // Check for an active Job and associate the file
    if (($jobId = session('file_job_upload')) && ($job = model(JobModel::class)->find($jobId))) {
        /** @var Job $job */
        $job->addFile($file->id);
    }

    // Ignore non-STL files
    if (strtolower($file->getExtension('clientname')) !== 'stl') {
        return;
    }

    // Initialize the reader for volume calculations only (saves memory)
    $reader = STLReader::forFile($file->getPath());
    $reader->setHandler(new VolumeHandler());

    try {
        $volume = $reader->readModel();
    } catch (InvalidFileFormatException $e) {
        alert('warning', lang('Actions.volumeFail'));
        log_message('error', 'Unable to calculate STL volume for ' . $file->localname . ': ' . $e->getMessage());

        return;
    }

    // Update the row in the database
    if ($volume > 0) {
        model(FileModel::class)->protect(false)->update($file->id, ['volume' => $volume]);

        return;
    }

    alert('warning', lang('Actions.volumeFail'));
});

/**
 * Captures new Chat messages to clear Notices.
 */
Events::on('chat', static function (array $data) {
    cache()->delete('notices');
});

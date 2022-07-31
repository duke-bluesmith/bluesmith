<?php

namespace App\Actions;

/**
 * Post Print Action
 *
 * Not really its own action, but an
 * extension of Print Action so staff
 * can track the time spent on each
 * portion of the physical processing.
 */
class PostprintAction extends PrintAction
{
    public const HANDLER_ID = 'postprint';
    public const ATTRIBUTES = [
        'name'     => 'Print Post-Process',
        'role'     => 'manageJobs',
        'icon'     => 'fas fa-broom',
        'category' => 'Process',
        'summary'  => 'Staff post-processes objects',
        'header'   => 'Print Post-Process',
        'button'   => 'Processing Complete',
    ];
}

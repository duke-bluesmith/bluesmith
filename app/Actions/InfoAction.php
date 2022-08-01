<?php

namespace App\Actions;

use Tatter\Workflows\Actions\InfoAction as BaseAction;

class InfoAction extends BaseAction
{
    use RenderTrait;

    public const ATTRIBUTES = [
        'name'     => 'Info',
        'role'     => '',
        'icon'     => 'fas fa-info-circle',
        'category' => 'Core',
        'summary'  => 'Set basic details of a job',
        'header'   => 'Info',
        'button'   => 'Continue',
    ];

    protected string $view = 'actions/info';
    protected array $rules = [
        'name'    => 'required|max_length[255]',
        'summary' => 'required|max_length[255]',
    ];
}

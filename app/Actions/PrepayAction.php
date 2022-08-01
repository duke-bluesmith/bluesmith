<?php

namespace App\Actions;

use Tatter\Workflows\Actions\ButtonAction;

class PrepayAction extends ButtonAction
{
    use RenderTrait;

    public const HANDLER_ID = 'prepay';
    public const ATTRIBUTES = [
        'name'     => 'Prepay',
        'role'     => '',
        'icon'     => 'fas fa-comments-dollar',
        'category' => 'Core',
        'summary'  => 'Client submits payment in advance',
        'header'   => 'Prepay',
        'button'   => 'Prepayment Processed',
        'view'     => 'Tatter\Workflows\Views\actions\button',
        'prompt'   => 'By clicking below I agree to pay the final amount charged.',
        'flag'     => 'Prepaid',
    ];
}

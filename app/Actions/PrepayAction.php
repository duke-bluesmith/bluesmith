<?php

namespace App\Actions;

use App\BaseAction;

class PrepayAction extends BaseAction
{
    public const HANDLER_ID = 'prepay';
    public const ATTRIBUTES = [
        'name'     => 'Prepay',
        'role'     => '',
        'icon'     => 'fas fa-comments-dollar',
    	'category' => 'Define',
        'summary'  => 'Client submits payment in advance',
        'header'   => 'Prepay',
        'button'   => 'Prepayment Processed',
    ];
}

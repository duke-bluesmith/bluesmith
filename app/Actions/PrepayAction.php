<?php namespace App\Actions;

use App\BaseAction;

class PrepayAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Define',
		'name'     => 'Prepay',
		'uid'      => 'prepay',
		'role'     => 'user',
		'icon'     => 'fas fa-comments-dollar',
		'summary'  => 'Client submits payment in advance',
	];
}

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
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Process',
		'name'     => 'Print Post-Process',
		'uid'      => 'postprint',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-broom',
		'summary'  => 'Staff post-processes objects',
		'header'   => 'Print Post-Process',
		'button'   => 'Processing Complete',
	];
}

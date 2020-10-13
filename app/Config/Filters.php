<?php

namespace Config;

use App\Filters\ManageFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use Myth\Auth\Filters\LoginFilter;
use Myth\Auth\Filters\RoleFilter;
use Myth\Auth\Filters\PermissionFilter;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'       => CSRF::class,
		'toolbar'    => DebugToolbar::class,
		'honeypot'   => Honeypot::class,
		'login'      => LoginFilter::class,
		'role'       => RoleFilter::class,
		'permission' => PermissionFilter::class,
		'manage'     => ManageFilter::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			// 'csrf',
		],
		'after'  => [
			'toolbar' => ['except' => 'api/*'],
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [
		'login'  => ['before' => ['account*', 'files*', 'jobs*']],
		'manage' => ['before' => ['manage*', 'actions*', 'workflows*']],
	];
}

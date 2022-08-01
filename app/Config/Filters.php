<?php

namespace Config;

use App\Filters\ManageFilter;
use App\Filters\PublicFilter;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use Myth\Auth\Filters\LoginFilter;
use Myth\Auth\Filters\PermissionFilter;
use Myth\Auth\Filters\RoleFilter;

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
        'public'     => PublicFilter::class,
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
        'after' => [
            'public'  => ['except' => ['api/*', 'manage*', 'actions*', 'emails/templates*', 'files/export/*', 'files/upload', 'workflows*']],
            'alerts'  => ['except' => 'api/*'],
            'assets'  => ['except' => 'api/*'],
            'themes'  => ['except' => 'api/*'],
            'toolbar' => ['except' => 'api/*'],
            'visits',
            // 'honeypot',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
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
        'login'  => ['before' => ['account*', 'clients*', 'files*', 'jobs*', 'preview*', 'api/preview*']],
        'manage' => [
            'before' => ['manage*', 'actions*', 'emails/templates*', 'workflows*'],
            'after'  => ['manage*', 'actions*', 'emails/templates*', 'workflows*', 'jobs*'],
        ],
    ];
}

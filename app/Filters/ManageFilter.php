<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Filters\PermissionFilter;
use Tatter\Menus\Breadcrumb;
use Tatter\Menus\Filters\MenusFilter;
use Tatter\Menus\Menus\BreadcrumbsMenu;

/**
 * Filter ManageFilter
 *
 * Wrapper to the filters for the management section:
 * - Myth:Auth's PermissionFilter for 'manageAny'
 * - MenusFilter for 'manage-menu'
 */
class ManageFilter implements FilterInterface
{
    /**
     * Verifies management permission.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        return (new PermissionFilter())->before($request, ['manageAny']);
    }

    /**
     * Renders the manage menu and injects its content.
     *
     * @param array|null $arguments
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface
    {
        // Special handling Breadcrumbs menu handling for job routes
        if (url_is('jobs/*') || url_is('manage/jobs/*')) {
            BreadcrumbsMenu::push(new Breadcrumb(base_url(), 'Home'));
            BreadcrumbsMenu::push(new Breadcrumb(site_url('manage'), 'Manage'));

            /** @var string[] $segments */
            $segments = service('request')->getUri()->getSegments();

            if (url_is('manage/jobs/show/*')) {
                BreadcrumbsMenu::push(new Breadcrumb(
                    current_url(),
                    'Job Details'
                ));
            } elseif (url_is('jobs/*') && count($segments) > 2) {
                // Next breadcrumb is the details
                BreadcrumbsMenu::push(new Breadcrumb(
                    site_url('manage/jobs/show/' . $segments[2]),
                    'Job Details'
                ));

                // Then add the Action (or "show")
                BreadcrumbsMenu::push(new Breadcrumb(
                    current_url(),
                    ucfirst($segments[1])
                ));
            }
        }

        return (new MenusFilter())->after($request, $response, ['breadcrumbs', 'manage-menu']);
    }
}

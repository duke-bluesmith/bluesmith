<?php namespace App\Filters;

use Myth\Auth\Filters\PermissionFilter;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Tatter\Menus\Filters\MenusFilter;

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
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $arguments = null)
	{
		return (new PermissionFilter)->before($request, ['manageAny']);
	}

	/**
	 * Renders the manage menu and injects its content.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return ResponseInterface|null
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface
	{
		return (new MenusFilter)->after($request, $response, ['breadcrumbs', 'manage-menu']);
	}
}

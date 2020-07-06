<?php namespace App\Filters;

use Myth\Auth\Filters\PermissionFilter;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * Filter ManageAnyFilter
 *
 * Convenience wrapper for Myth:Auth's PermissionFilter for 'ManageAny'
 */
class ManageFilter extends PermissionFilter
{
	public function before(RequestInterface $request, $params = null)
	{
		return parent::before($request, ['ManageAny']);
	}
}

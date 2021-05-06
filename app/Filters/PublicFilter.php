<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Menus\Filters\MenusFilter;

class PublicFilter extends MenusFilter
{
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): ?ResponseInterface
	{
		return parent::after($request, $response, ['public-menu']);
	}
}

<?php

use CodeIgniter\Test\FilterTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class RouteFiltersTest extends ProjectTestCase
{
	use FilterTestTrait;

	/**
	 * @dataProvider routeProvider
	 *
	 * @param mixed $route
	 * @param mixed $alias
	 */
	public function testRoutes($route, $alias)
	{
		if ($alias)
		{
			$this->assertFilter($route, 'before', $alias);
		}
		else {
			$this->assertNotHasFilters($route, 'before');
		}
	}

	public function routeProvider()
	{
		return [
			['/', null],
			['about/options', null],
			['account/jobs', 'login'],
			['files/index', 'login'],
			['manage/jobs', 'manage'],
			['manage/content/branding', 'manage'],
			['manage/content/page', 'manage'],
			['manage/materials', 'manage'],
			['manage/materials/method/1', 'manage'],
			['actions', 'manage'],
			['workflows', 'manage'],
		];
	}
}

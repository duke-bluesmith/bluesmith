<?php

use App\Filters\ManageFilter;
use CodeIgniter\Test\FilterTestTrait;
use Tests\Support\ProjectTestCase;

class RouteFiltersTest extends ProjectTestCase
{
	use FilterTestTrait;

	/**
	 * @dataProvider routeProvider
	 */
	public function testRoutes($route, $alias)
	{
		if ($alias)
		{
			$this->assertFilter($route, 'before', $alias);
		}
		else
		{
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

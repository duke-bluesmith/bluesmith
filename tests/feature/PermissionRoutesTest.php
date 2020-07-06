<?php

use Tests\Support\FeatureTestCase;

class PermissionRoutesTest extends FeatureTestCase
{
	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = false;

	protected function setUp(): void
	{
		parent::setUp();

		// Initialize the simulation only once since it is costly.
		if (! Simulator::$initialized)
		{
			Simulator::initialize();
		}
	}

	/**
	 * @dataProvider routeProvider
	 */
	public function testManageRequiresLogin($route, $status)
	{
		$result = $this->get($route);

		$result->assertOk();
		
		if ($status === 'any')
		{
			$result->assertStatus(200);
		}
		else
		{
			$result->assertRedirect();
		}
	}

	public function routeProvider()
	{
		return [
			['/', 'any'],
			['manage', 'manage'],
			['manage/', 'manage'],
			['manage/content/branding', 'manage'],
			['manage/content/page', 'manage'],
			['manage/jobs/page', 'manage'],
			['manage/jobs/page', 'manage'],
			['manage/materials', 'manage'],
			['manage/materials/method/1', 'manage'],
		];
	}
}
//		'login' => ['before' => ['account*', 'manage*', 'files*', 'jobs*', 'tasks*', 'workflows*']]
/*

// Admin dashboard
$routes->group('manage', ['filter'=>'permission:ManageAny', 'namespace'=>'App\Controllers\Manage'], function($routes)
{
	$routes->add('/', 'Dashboard::index');

	$routes->get('content/(:any)', 'Content::$1');
	$routes->post('content/(:any)', 'Content::$1');

	$routes->get('materials/method/(:any)', 'Materials::method/$1');
	$routes->presenter('materials');
});

*/
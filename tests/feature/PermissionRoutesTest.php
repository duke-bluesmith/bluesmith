<?php

use App\Entities\User;
use App\Models\JobModel;
use Myth\Auth\Exceptions\PermissionException;
use App\Models\UserModel;
use Tests\Support\FeatureTestCase;
use Tests\Support\Simulator;

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

		$this->resetAuthServices();
		$this->simulateOnce();
	}

	/**
	 * @dataProvider routeProvider
	 */
	public function testNotLoggedIn($route, $status)
	{
		$result = $this->get($route);

		$result->assertOk();
		
		if ($status === 'public')
		{
			$result->assertStatus(200);
		}
		else
		{
			$result->assertRedirect();
		}
	}

	/**
	 * @dataProvider routeProvider
	 */
	public function testLoggedInNoPermissions($route, $status)
	{
		$user = fake(UserModel::class);

		// The filter will throw if user does not have access
		if ($status === 'manage')
		{
			$this->expectException(\RuntimeException::class); // WIP Change to PermissionException when merged
			$this->expectExceptionMessage(lang('Auth.notEnoughPrivilege'));
		}

		$result = $this->withSession(['logged_in' => $user->id])->get($route);

		// Below only executes when access was granted
		$result->assertOk();
		$result->assertStatus(200);
	}

	/**
	 * @dataProvider routeProvider
	 */
	public function testHasPermissionManageAny($route, $status)
	{
		$user = $this->createUserWithPermission('manageAny');

		$result = $this->withSession(['logged_in' => $user->id])->get($route);
		$result->assertOk();
		$result->assertStatus(200);
	}

	/**
	 * @dataProvider routeProvider
	 */
	public function testInGroupConsultants($route, $status)
	{
		$user = $this->createUserInGroup('Consultants');

		$result = $this->withSession(['logged_in' => $user->id])->get($route);
		$result->assertOk();
		$result->assertStatus(200);
	}

	/**
	 * @dataProvider routeProvider
	 */
	public function testInGroupAdministrators($route, $status)
	{
		$user = $this->createUserInGroup('Administrators');

		$result = $this->withSession(['logged_in' => $user->id])->get($route);
		$result->assertOk();
		$result->assertStatus(200);
	}

	public function routeProvider()
	{
		return [
			['/', 'public'],
			['about/options', 'public'],
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

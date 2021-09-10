<?php

use App\Database\Seeds\AuthSeeder;
use App\Menus\ManageMenu;
use App\Menus\PublicMenu;
use CodeIgniter\HTTP\URI;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FilterTestTrait;
use Config\Services;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

class MenusTest extends ProjectTestCase
{
	use AuthenticationTrait, DatabaseTestTrait, FilterTestTrait;

	/**
	 * Expected value for the baseline public menu
	 *
	 * @var string
	 */
	private static $expectedPublic;

	/**
	 * Expected value for the baseline manage menu
	 *
	 * @var string
	 */
	private static $expectedManage;

	protected $seedOnce    = true;
	protected $migrateOnce = true;
	protected $seed        = AuthSeeder::class;
	protected $namespace   = [
		'Myth\Auth',
		'Tatter\Files',
		'Tatter\Workflows',
		'App',
	];

	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		self::$expectedPublic = '<ul class="navbar-nav mr-auto"><li class="active exact-active nav-item"><a href="' . site_url() . '" class="nav-link"><i class="fas fa-home"></i> Home</a></li><li class="nav-item"><a href="' . site_url('about/options') . '" class="nav-link"><i class="fas fa-cogs"></i> Options</a></li><li class="nav-item"><a href="' . site_url('files/user') . '" class="nav-link"><i class="fas fa-file-alt"></i> My files</a></li><li class="nav-item"><a href="' . site_url('account/jobs') . '" class="nav-link"><i class="fas fa-cubes"></i> Jobs</a></li></ul>';
		self::$expectedManage = '<ul data-widget="treeview" role="menu" data-accordion="false" class="nav nav-pills nav-sidebar flex-column"><li class="nav-item"><a href="' . site_url('manage/dashboard') . '" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p><span class="right badge badge-warning">' . count(service('notifications')) . '</span></a></li><li class="nav-item has-treeview menu-open"><a href="' . site_url('manage/jobs') . '" class="nav-link has-treeview"><i class="nav-icon fas fa-th-list"></i><p>Jobs<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview"><li class="nav-item"><a href="' . site_url('manage/jobs/active') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Active Jobs</p></a></li><li class="nav-item"><a href="' . site_url('manage/jobs/archive') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Archived Jobs</p></a></li><li class="nav-item"><a href="' . site_url('manage/jobs/all') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All Jobs</p></a></li></ul></li><li class="nav-item has-treeview menu-open"><a href="' . site_url('manage/users') . '" class="nav-link has-treeview"><i class="nav-icon fas fa-user-friends"></i><p>Users<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview"><li class="nav-item"><a href="' . site_url('manage/users/index') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All Users</p></a></li><li class="nav-item"><a href="' . site_url('manage/users/staff') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Staff</p></a></li></ul></li><li class="nav-item has-treeview"><a href="' . site_url('workflows') . '" class="nav-link has-treeview"><i class="nav-icon fas fa-project-diagram"></i><p>Workflows<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview"><li class="nav-item"><a href="' . site_url('workflows') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Index</p></a></li><li class="nav-item"><a href="' . site_url('actions') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Actions</p></a></li></ul></li><li class="nav-header">CONTENT MANAGEMENT</li><li class="nav-item has-treeview"><a href="' . site_url('emails/templates') . '" class="nav-link has-treeview"><i class="nav-icon fas fa-inbox"></i><p>Email<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview"><li class="nav-item"><a href="' . site_url('emails/templates') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>List Templates</p></a></li><li class="nav-item"><a href="' . site_url('emails/templates/new') . '" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Add Template</p></a></li></ul></li><li class="nav-item has-treeview"><a href="' . site_url('manage/content/page') . '" class="nav-link has-treeview"><i class="nav-icon fas fa-file-alt"></i><p>Pages<i class="right fas fa-angle-left"></i></p></a><ul class="nav nav-treeview"></ul></li><li class="nav-item"><a href="' . site_url('manage/methods') . '" class="nav-link"><i class="nav-icon fas fa-cubes"></i><p>Methods</p></a></li><li class="nav-item"><a href="' . site_url('manage/materials') . '" class="nav-link"><i class="nav-icon fas fa-tools"></i><p>Materials</p></a></li><li class="nav-item"><a href="' . site_url('manage/content/branding') . '" class="nav-link"><i class="nav-icon fas fa-copyright"></i><p>Branding</p></a></li></ul>';
	}

	protected function setUp(): void
	{
		parent::setUp();

		// Set the current URL
		$_SERVER['REQUEST_URI'] = '/';
		Services::resetSingle('request');
	}

	public function testPublicMenuUser()
	{
		$result = (string) (new PublicMenu);

		$this->assertSame(self::$expectedPublic, $result);
	}

	public function testPublicMenuStaff()
	{
		$expected = str_replace('</ul>', '<li class="nav-item"><a href="' . site_url('manage') . '" class="nav-link"><i class="fas fa-user-shield"></i> Manage</a></li></ul>', self::$expectedPublic);

		$this->addPermissionToUser('manageAny');
		$result = (string) (new PublicMenu);

		$this->assertSame($expected, $result);
	}

	public function testPublicMenuActive()
	{
		$class    = 'active exact-active ';
		$expected = str_replace($class, '', self::$expectedPublic);
		$expected = str_replace('files</a></li><li class="', 'files</a></li><li class="' . $class, $expected);

		// Fake a different URL
		$_SERVER['REQUEST_URI'] = '/account/jobs';
		Services::resetSingle('request');

		$result = (string) (new PublicMenu);

		$this->assertSame($expected, $result);
	}

	public function testManageMenu()
	{
		$result = (string) (new ManageMenu);

		$this->assertSame(self::$expectedManage, $result);
	}
}


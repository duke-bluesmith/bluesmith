<?php

namespace Config;

use App\Menus\ManageMenu;
use App\Menus\PublicMenu;
use Tatter\Menus\Config\Menus as BaseMenus;
use Tatter\Menus\Menus\BreadcrumbsMenu;

class Menus extends BaseMenus
{
	/**
	 * Menu class aliases.
	 *
	 * @var array<string, string>
	 */
	public $aliases = [
		'breadcrumbs' => BreadcrumbsMenu::class,
		'manage-menu' => ManageMenu::class,
		'public-menu' => PublicMenu::class,
	];
}

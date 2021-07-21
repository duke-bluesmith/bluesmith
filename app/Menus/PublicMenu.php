<?php namespace App\Menus;

use Tatter\Menus\Menu;
use Tatter\Menus\Styles\BootstrapStyle;

class PublicMenu extends Menu
{
	use BootstrapStyle;

	/**
	 * Builds the Menu and returns the
	 * rendered HTML string.
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		$this->builder
			->link(site_url(), '<i class="fas fa-home"></i> Home')
			->link(site_url('about/options'), '<i class="fas fa-cogs"></i> Options')
			->link(site_url('files/user'), '<i class="fas fa-file-alt"></i> My files')
			->link(site_url('account/jobs'), '<i class="fas fa-cubes"></i> Jobs');

		// Check for management access
		if (has_permission('manageAny'))
		{
			$this->builder->link(site_url('manage'), '<i class="fas fa-user-shield"></i> Manage');
		}

		return $this->builder->render();
	}
}

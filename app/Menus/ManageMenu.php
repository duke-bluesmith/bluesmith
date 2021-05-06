<?php namespace App\Menus;

use App\Models\PageModel;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;
use Tatter\Menus\Menu as BaseMenu;
use Tatter\Menus\Styles\AdminLTEStyle;

class ManageMenu extends BaseMenu
{
	use AdminLTEStyle;

	/**
	 * Builds the Menu and returns the
	 * rendered HTML string.
	 *
	 * @return string
	 */
	public function __toString(): string
	{
		// Submenus
		$this->jobsSubmenu();
		$this->usersSubmenu();
		$this->workflowsSubmenu();

		// Divider
		$this->builder->html('CONTENT MANAGEMENT', ['class' => 'nav-header']);

		// Submenus
		$this->emailsSubmenu();
		$this->pagesSubmenu();

		// Top level links
		$this->builder
			->link(site_url('manage/methods'), '<i class="nav-icon fas fa-cubes"></i><p>Methods</p>')
			->link(site_url('manage/materials'), '<i class="nav-icon fas fa-tools"></i><p>Materials</p>')
			->link(site_url('manage/content/branding'), '<i class="nav-icon fas fa-copyright"></i><p>Branding</p>');

		return $this->builder->render();
	}

	/**
	 * Adds the Jobs submenu.
	 *
	 * @return void
	 */
	private function jobsSubmenu(): void
	{
		$this->builder
			->submenu(
				Link::to(site_url('manage/jobs'), '<i class="nav-icon fas fa-th-list"></i><p>Jobs<i class="right fas fa-angle-left"></i></p>')->addClass('nav-link has-treeview'),
				function (Menu $menu) {
					$menu
						->addClass('nav nav-treeview')
						->addParentClass('nav-item has-treeview menu-open')
						->setActiveClassOnLink()
						->link(site_url('manage/jobs/staff'), '<i class="far fa-circle nav-icon"></i><p>Action Items</p><span class="right badge badge-warning">12</span>')
						->link(site_url('manage/jobs/active'), '<i class="far fa-circle nav-icon"></i><p>Active Jobs</p>')
						->link(site_url('manage/jobs/archive'), '<i class="far fa-circle nav-icon"></i><p>Archived Jobs</p>')
						->link(site_url('manage/jobs/all'), '<i class="far fa-circle nav-icon"></i><p>All Jobs</p>');
				}
			);
	}

	/**
	 * Adds the Users submenu.
	 *
	 * @return void
	 */
	private function usersSubmenu(): void
	{
		$this->builder
			->submenu(
				Link::to(site_url('manage/users'), '<i class="nav-icon fas fa-user-friends"></i><p>Users<i class="right fas fa-angle-left"></i></p>')->addClass('nav-link has-treeview'),
				function (Menu $menu) {
					$menu
						->addClass('nav nav-treeview')
						->addParentClass('nav-item has-treeview menu-open')
						->setActiveClassOnLink()
						->link(site_url('manage/users/index'), '<i class="far fa-circle nav-icon"></i><p>All Users</p>')
						->link(site_url('manage/users/staff'), '<i class="far fa-circle nav-icon"></i><p>Staff</p>');
				}
			);
	}

	/**
	 * Adds the Workflows submenu.
	 *
	 * @return void
	 */
	private function workflowsSubmenu(): void
	{
		$this->builder
			->submenu(
				Link::to(site_url('workflows'), '<i class="nav-icon fas fa-project-diagram"></i><p>Workflows<i class="right fas fa-angle-left"></i></p>')->addClass('nav-link has-treeview' . (url_is('actions') ? ' active' : '')),
				function (Menu $menu) {
					$menu
						->addClass('nav nav-treeview')
						->addParentClass('nav-item has-treeview')
						->setActiveClassOnLink()
						->link(site_url('workflows'), '<i class="far fa-circle nav-icon"></i><p>Index</p>')
						->link(site_url('actions'), '<i class="far fa-circle nav-icon"></i><p>Actions</p>');
				}
			);
	}

	/**
	 * Adds the Emails submenu.
	 *
	 * @return void
	 */
	private function emailsSubmenu(): void
	{
		$this->builder
			->submenu(
				Link::to(site_url('emails/templates'), '<i class="nav-icon fas fa-inbox"></i><p>Email<i class="right fas fa-angle-left"></i></p>')->addClass('nav-link has-treeview'),
				function (Menu $menu) {
					$menu
						->addClass('nav nav-treeview')
						->addParentClass('nav-item has-treeview')
						->setActiveClassOnLink()
						->link(site_url('emails/templates'), '<i class="far fa-circle nav-icon"></i><p>List Templates</p>')
						->link(site_url('emails/templates/new'), '<i class="far fa-circle nav-icon"></i><p>Add Template</p>');
				}
			);
	}

	/**
	 * Adds the Pages submenu.
	 *
	 * @return void
	 */
	private function pagesSubmenu(): void
	{
		$this->builder
			->submenu(
				Link::to(site_url('manage/content/page'), '<i class="nav-icon fas fa-file-alt"></i><p>Pages<i class="right fas fa-angle-left"></i></p>')->addClass('nav-link has-treeview'),
				function (Menu $menu) {
					$menu
						->addClass('nav nav-treeview')
						->addParentClass('nav-item has-treeview')
						->setActiveClassOnLink();

					foreach (model(PageModel::class)->findAll() as $page)
					{
						$menu->link(site_url('manage/content/page/' . $page->name), '<i class="far fa-circle nav-icon"></i><p>' . ucfirst($page->name) . '</p>');
					}
				}
			);
	}
}

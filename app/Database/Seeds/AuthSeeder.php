<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Models\UserModel;

class AuthSeeder extends Seeder
{
	public function run()
	{
		// Initialize the classes
		$groups        = new GroupModel();
		$permissions   = new PermissionModel();
		$users         = new UserModel();
		$authorization = service('authorization'); 

		/*** GROUPS ***/
		// Test for and create the necessary groups

		$rows = [
			['name' => 'Administrators', 'description' => 'Staff with full access to the application'],
			['name' => 'Consultants',    'description' => 'Staff who facilitate and manage print jobs'],
			['name' => 'Editors',        'description' => 'Staff who can access the CMS to update content'],
			['name' => 'VIPs',           'description' => 'Patrons with priority printing access'],
		];
		foreach ($rows as $row)
		{
			$group = $groups->where('name', $row['name'])->first();

			if (empty($group))
			{
				$groups->insert($row);
			}
		}

		/** PERMISSIONS ***/
		// Test for and create the necessary permissions

		$rows = [
			['name' => 'manageAny',     'description' => 'General access to the admin dashboard'],
			['name' => 'manageContent', 'description' => 'Access to the CMS'],
			['name' => 'manageJobs',    'description' => 'Access to perform job updates'],
		];
		foreach ($rows as $row)
		{
			$permission = $permissions->where('name', $row['name'])->first();

			if (empty($permission))
			{
				$permissions->insert($row);
			}
		}

		/*** GROUPS_PERMISSIONS ***/
		// Authorize groups for access to various sections

		// General dashboard access
		$names = ['Administrators', 'Consultants', 'Editors'];
		foreach ($names as $name)
		{
			$authorization->removePermissionFromGroup('manageAny', $name);
			$authorization->addPermissionToGroup('manageAny', $name);
		}

		// CMS access
		$names = ['Administrators', 'Editors'];
		foreach ($names as $name)
		{
			$authorization->removePermissionFromGroup('manageContent', $name);
			$authorization->addPermissionToGroup('manageContent', $name);
		}

		// Job management access
		$names = ['Administrators', 'Consultants'];
		foreach ($names as $name)
		{
			$authorization->removePermissionFromGroup('manageJobs', $name);
			$authorization->addPermissionToGroup('manageJobs', $name);
		}
	}
}
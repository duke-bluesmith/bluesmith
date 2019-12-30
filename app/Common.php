<?php

use App\Models\UserModel;
use Config\Services;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

// Define our own user() function to return the extended entity
if (! function_exists('user'))
{
	/**
	 * Returns the User instance for the current logged in user.
	 *
	 * @return \App\Entities\User|null
	 */
	function user()
	{
		$authenticate = Services::authentication();
		if ($authenticate->check())
		{
			return (new UserModel())->find($authenticate->id());
		}
		return null;
	}
}

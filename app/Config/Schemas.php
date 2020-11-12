<?php namespace Config;

/***
*
* This file contains example values to alter default library behavior.
* Recommended usage:
*	1. Copy the file to app/Config/
*	2. Change any values
*	3. Remove any lines to fallback to defaults
*
***/

class Schemas extends \Tatter\Schemas\Config\Schemas
{
	// Whether to continue instead of throwing exceptions
	public $silent = false;

	// Namespaces to ignore (mostly for ModelHandler)
	public $ignoredNamespaces = [
		'CodeIgniter\Commands\Generators',
		'Myth\Auth\Models',
		'Tatter\Permits\Models',
		'Tests\Support',
	];
}

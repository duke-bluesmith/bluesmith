<?php

namespace Config;

class Permits extends \Tatter\Permits\Config\Permits
{
	// number of seconds to cache a permission
	public $cacheDuration = 300;

	// whether to continue instead of throwing exceptions
	public $silent = false;
}

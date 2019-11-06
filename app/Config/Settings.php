<?php namespace Config;

class Settings extends \Tatter\Settings\Config\Settings
{
	// number of seconds to cache a setting
	// 0 disables caching (not recommended except for testing)
	public $cacheDuration = 300;
}

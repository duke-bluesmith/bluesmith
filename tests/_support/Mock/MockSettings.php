<?php namespace Tests\Support\Mock;

use Tatter\Settings\Models\SettingModel;
use Tatter\Settings\Settings;

/**
 * Mock Settings Class
 *
 * Provides public properties for project
 * settings to circumvent Settings::__call()
 * and eliminate the need for a database.
 */
final class MockSettings extends Settings
{
	/**
	 * @var string
	 */
	public $currencyUnit = 'USD';

	/**
	 * @var int
	 */
	public $currencyScale = 100;

	/**
	 * Convenience constructor to handle
	 * dependencies.
	 */
	public static function create(): self
	{
		return new self(config('Settings'), model(SettingModel::class), service('session'));		
	}
}

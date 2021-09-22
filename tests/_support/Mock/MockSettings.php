<?php

namespace Tests\Support\Mock;

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
}

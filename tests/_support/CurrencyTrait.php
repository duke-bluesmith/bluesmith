<?php namespace Tests\Support;

use Config\Services;
use Tests\Support\Mock\MockSettings;

/**
 * Currency Test Trait
 *
 * Mocks currency Settings to eliminate
 * the need for a database.
 */
trait CurrencyTrait
{
	/**
	 * Loads the helpers and injects Mock Settings.
	 */
	protected function setUpCurrencyTrait(): void
	{
		if (! function_exists('price_to_currency'))
		{
			helper(['currency', 'number']);
		}

		Services::injectMock('settings', MockSettings::create());
	}
}

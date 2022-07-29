<?php

namespace Config;

use Tatter\Preferences\Config\Preferences as BaseConfig;

class Preferences extends BaseConfig
{
	/**
	 * Brand name for this project.
	 */
	protected string $brandName = 'Bluesmith';

	/**
	 * Brand logo for this project.
	 */
	protected string $brandLogo = 'assets/images/logo.png';

	/**
	 * Your organization name.
	 */
	protected string $orgName = 'Organization';

	/**
	 * Your organization logo.
	 */
	protected string $orgLogo = 'assets/images/logo.png';

	/**
	 * Your organization URL.
	 */
	protected string $orgUrl = 'https://example.com';

	/**
	 * Your organization address.
	 */
	protected string $orgAddress = '4141 Postmark Dr, Anchorage, AK';

	/**
	 * Your organization phone.
	 */
	protected string $orgPhone = '(951) 262-3062';

	/**
	 * Timezone for the database server(s).
	 */
	protected string $databaseTimezone = 'UTC';

	/**
	 * Timezone for the web server(s).
	 * (Not to be confused with Config\App::$appTimezone)
	 */
	protected string $serverTimezone = 'UTC';

	/**
	 * Currency format for number helper.
	 */
	protected string $currencyUnit = 'USD';

	/**
	 * Conversion rate to the fractional monetary unit.
	 */
	protected int $currencyScale = 100;
}

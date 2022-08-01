<?php

namespace Config;

use Tatter\Preferences\Config\Preferences as BaseConfig;

class Preferences extends BaseConfig
{
    /**
     * Brand name for this project.
     */
    public string $brandName = 'Bluesmith';

    /**
     * Brand logo for this project.
     */
    public string $brandLogo = 'assets/images/logo.png';

    /**
     * Your organization name.
     */
    public string $orgName = 'Organization';

    /**
     * Your organization logo.
     */
    public string $orgLogo = 'assets/images/logo.png';

    /**
     * Your organization URL.
     */
    public string $orgUrl = 'https://example.com';

    /**
     * Your organization address.
     */
    public string $orgAddress = '4141 Postmark Dr, Anchorage, AK';

    /**
     * Your organization phone.
     */
    public string $orgPhone = '(951) 262-3062';

    /**
     * Timezone for the database server(s).
     */
    public string $databaseTimezone = 'UTC';

    /**
     * Timezone for the web server(s).
     * (Not to be confused with Config\App::$appTimezone)
     */
    public string $serverTimezone = 'UTC';

    /**
     * Currency format for number helper.
     */
    public string $currencyUnit = 'USD';

    /**
     * Conversion rate to the fractional monetary unit.
     */
    public int $currencyScale = 100;
}

<?php

namespace Config;

class Auth extends \Myth\Auth\Config\Auth
{
    //--------------------------------------------------------------------
    // Layout for the views to extend
    //--------------------------------------------------------------------

    public $viewLayout = 'layouts/public';

    //--------------------------------------------------------------------
    // Allow User Registration
    //--------------------------------------------------------------------
    // When enabled (default) any unregistered user may apply for a new
    // account. If you disable registration you may need to ensure your
    // controllers and views know not to offer registration.
    //
    public $allowRegistration = true;

    //--------------------------------------------------------------------
    // Allow Persistent Login Cookies (Remember me)
    //--------------------------------------------------------------------
    // While every attempt has been made to create a very strong protection
    // with the remember me system, there are some cases (like when you
    // need extreme protection, like dealing with users financials) that
    // you might not want the extra risk associated with this cookie-based
    // solution.
    //
    public $allowRemembering = true;

    //--------------------------------------------------------------------
    // Remember Length
    //--------------------------------------------------------------------
    // The amount of time, in seconds, that you want a login to last for.
    // Defaults to 30 days.
    //
    public $rememberLength = 30 * DAY;

    //--------------------------------------------------------------------
    // Allow Invitations
    //--------------------------------------------------------------------
    // When enabled (default) users may invite unregistered users to
    // create an account and collaborate on a specific job. This will
    // generate a tokenized URL to send to the specified email that will
    // prompt the user to make an account.
    //
    public $allowInvitations = true;

    //--------------------------------------------------------------------
    // Remember Length
    //--------------------------------------------------------------------
    // The amount of time, in seconds, that you want invitations tokens to
    // to be valid before expiring. Set to 0 to disable expiration.
    // Defaults to 7 days.
    //
    public $invitationLength = 7 * DAY;
}

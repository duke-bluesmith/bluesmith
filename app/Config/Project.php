<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Project extends BaseConfig
{
    /**
     * When enabled (default) users may invite unregistered users to
     * create an account and collaborate on a specific job. This will
     * generate a tokenized URL to send to the specified email that will
     * prompt the user to make an account.
     */
    public bool $allowInvitations = true;

    /**
     * The amount of time, in seconds, that you want invitations tokens to
     * to be valid before expiring. Set to 0 to disable expiration.
     * Defaults to 7 days.
     */
    public int $invitationLength = 7 * DAY;
}

<?php

namespace Config;

class Visits extends \Tatter\Visits\Config\Visits
{
	// metric for tracking a unique visitor, one of: ip_address, session_id, user_id
	// NOTE: using user_id will count empty $userSource values as unique visits
	public $trackingMethod = 'ip_address';

	// Whether to ignore AJAX requests when recording
	public $ignoreAjax = true;
}

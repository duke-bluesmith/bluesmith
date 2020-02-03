<?php namespace App\Controllers\API;

use CodeIgniter\Controller;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Email extends Controller
{
	/**
	 * Handle unsubscribing
	 *
	 * @return string
	 */
	public function unsubscribe(string $token = null): string
	{
		return 'done';
	}

	/**
	 * Returns the HTML email template with inlined CSS and tokens for use by external clients
	 *
	 * @return string
	 */
	public function template()
	{
		$inliner = new CssToInlineStyles();

		return $inliner->convert(view('emails/template'), view('emails/styles'));
	}

	/**
	 * Returns an example email using the default template
	 *
	 * @return string
	 */
	public function example()
	{
		$inliner = new CssToInlineStyles();

		return $inliner->convert(view('emails/example'), view('emails/styles'));
	}
}

<?php namespace Tests\Support;

use Myth\Auth\Test\AuthTestTrait;

/**
 * Authentication Test Trait
 *
 * Provides support functions for any
 * tests needing users and authentication.
 */
trait AuthenticationTrait
{
	use \Myth\Auth\Test\AuthTestTrait;

	/**
	 * Append the methods here since no
	 * other tests use the constructor.
	 */
	protected function tearDownAuth(): void
	{
		$this->resetAuthServices();
	}
}

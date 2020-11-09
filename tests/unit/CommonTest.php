<?php

use App\Entities\User;
use Tests\Support\DatabaseTestCase;

/**
 * Tests functions defined in Common.php
 */
class CommonTest extends DatabaseTestCase
{
	protected function setUp(): void
	{
		parent::setUp();

		$this->resetAuthServices();
		helper('auth');
	}

	public function testUserReturnsNull()
	{
		$result = user();

		$this->assertNull($result);
	}

	public function testUserReturnsAppUser()
	{
		$this->createAuthUser();
		$result = user();

		$this->assertEquals(User::class, get_class($result));
	}
}

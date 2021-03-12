<?php

use App\Entities\User;
use Tests\Support\ProjectTestCase;

/**
 * Tests functions defined in Common.php
 */
class CommonTest extends ProjectTestCase
{
	use \CodeIgniter\Test\DatabaseTestTrait;
	use \Tests\Support\AuthenticationTrait;

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

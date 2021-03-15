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

	public function testUserReturnsAppEntity()
	{
		$result = user();

		$this->assertNotNull($result);
		$this->assertEquals(User::class, get_class($result));
	}

	public function testUserReturnsNull()
	{
		$this->resetAuthServices();

		$result = user();

		$this->assertNull($result);
	}
}

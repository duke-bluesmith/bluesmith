<?php

use App\Entities\User;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

/**
 * Tests functions defined in Common.php
 */
class CommonTest extends ProjectTestCase
{
	use AuthenticationTrait, DatabaseTestTrait;

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

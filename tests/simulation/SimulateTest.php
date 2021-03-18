<?php

use App\Models\MethodModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * Tests for the Simulate Command
 */
class SimulateTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	public function testTruncatesTables()
	{
		model(MethodModel::class)->insert(['name' => 'foobar']);

		command('simulate');

		$this->dontSeeInDatabase('methods', ['name' => 'foobar']);
	}
}

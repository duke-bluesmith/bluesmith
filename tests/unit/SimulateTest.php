<?php

use App\Models\MethodModel;
use Tests\Support\ProjectTestCase;

/**
 * Tests for the Simulate Command
 */
class SimulateTest extends ProjectTestCase
{
	use \CodeIgniter\Test\DatabaseTestTrait;

	public function testTruncatesTables()
	{
		model(MethodModel::class)->insert(['name' => 'foobar']);

		command('simulate');

		$this->dontSeeInDatabase('methods', ['name' => 'foobar']);
	}
}

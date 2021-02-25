<?php

use App\Models\MethodModel;
use Tests\Support\DatabaseTestCase;

/**
 * Tests for the Simulate Command
 */
class SimulateTest extends DatabaseTestCase
{
	public function testTruncatesTables()
	{
		model(MethodModel::class)->insert(['name' => 'foobar']);

		command('simulate');

		$this->dontSeeInDatabase('methods', ['name' => 'foobar']);
	}
}

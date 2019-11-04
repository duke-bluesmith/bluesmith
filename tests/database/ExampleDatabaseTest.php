<?php

class ExampleDatabaseTest extends ProjectTests\Support\ProjectTestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function testDatabaseSimple()
	{
		$model = new \ProjectTests\Support\Models\ExampleModel();

		$objects = $model->findAll();

		$this->assertCount(3, $objects);
	}

	public function testSessionSimple()
	{
		$this->session->set('logged_in', 123);

		$value = $this->session->get('logged_in');

		$this->assertEquals(123, $value);
	}
}

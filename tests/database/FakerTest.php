<?php

use App\Models\JobModel;

/**
 * Tests for the faker methods
 */
class FakerTest extends ProjectTests\Support\ProjectTestCase
{
	use ProjectTests\Support\Traits\FakerTrait;

	/**
	 * Should the database be refreshed before each test?
	 *
	 * @var boolean
	 */
	protected $refresh = true;
	
	public function setUp(): void
	{
		parent::setUp();

		$this->fakerSetUp();
	}

	public function testCreateAddsToDatabase()
	{
		$model = new JobModel();

		$expected = $this->createFaked('job');

		$this->assertEquals($expected, $model->findColumn('id'));
	}

	public function testCreateAddsNumRows()
	{
		$num   = 20;
		$model = new JobModel();

		$this->createFaked('job', $num);

		$this->assertCount($num, $model->findColumn('id'));
	}
}

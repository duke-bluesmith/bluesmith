<?php namespace App\Models;

use App\Models\CompiledRowsTrait;
use CodeIgniter\Model;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;
use Tests\Support\Simulator;

class CompiledRowsTraitTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	protected $migrateOnce = true;
	protected $seedOnce    = true;
	protected $refresh     = false;

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * Creates an anonymous traited model
	 * for easy trait access.
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->model = new class extends Model {

			use CompiledRowsTrait;

			protected $table = 'bananas';

			protected $afterInsert = ['clearCompiledRows'];
			protected $afterUpdate = ['clearCompiledRows'];
			protected $afterDelete = ['clearCompiledRows'];

			/**
			 * Fetch or build the compiled rows for browsing,
			 * applying filters, and sorting.
			 *
			 * @return array[]
			 */
			protected function fetchCompiledRows(): array
			{
				return [
					[
						'id'         => 1,
						'name'       => 'first',
						'created_at' => '2021-01-21 12:21:12',
					],
					[
						'id'         => 2,
						'name'       => 'last',
						'created_at' => '2021-02-12 21:12:21',
					],
				];
			}

			/**
			 * Exposes the trigger method to test
			 * clearing the cache.
			 *
			 * @param string $event
			 * @param array  $eventData
			 *
			 * @return mixed
			 *
			 * @throws DataException
			 */
			public function trigger(string $event, array $eventData = [])
			{
				parent::trigger($event, $eventData);
			}
		};		
	}

	public function testGet()
	{
		$result = $this->model->getCompiledRows();

		$this->assertIsArray($result);
		$this->assertCount(2, $result);
		$this->assertEquals(['id', 'name', 'created_at'], array_keys($result[0]));
	}

	public function testClear()
	{
		cache()->save('bananasrows', ['foo' => 'bar']);

		$this->model->clearCompiledRows();
		$result = $this->model->getCompiledRows();

		$this->assertArrayNotHasKey('foo', $result);
	}

	public function testCreatesCache()
	{
		$this->assertNull(cache()->get('bananasrows'));

		$this->model->getCompiledRows();

		$this->assertNotNull(cache()->get('bananasrows'));
	}

	public function testUsesCache()
	{
		$expected = ['foo' => 'bar'];
		cache()->save('bananasrows', $expected);

		$result = $this->model->getCompiledRows();

		$this->assertSame($expected, $result);
	}

	public function testEventsClearCache()
	{
		foreach (['afterInsert', 'afterUpdate', 'afterDelete'] as $event)
		{
			cache()->save('bananasrows', ['foo' => 'bar']);
			$this->model->trigger($event);
			$this->assertNull(cache()->get('bananasrows'));
		}
	}
}

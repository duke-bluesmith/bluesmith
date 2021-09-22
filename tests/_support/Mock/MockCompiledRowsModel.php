<?php

namespace Tests\Support\Mock;

use App\Models\CompiledRowsTrait;
use CodeIgniter\Model;

class MockCompiledRowsModel extends Model
{
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
			[
				'id'         => 2,
				'name'       => 'duplicate',
				'created_at' => '2020-01-01 20:01:01',
			],
		];
	}

	/**
	 * Exposes the trigger method to test
	 * clearing the cache.
	 */
	public function trigger(string $event, array $eventData = [])
	{
		parent::trigger($event, $eventData);
	}
}

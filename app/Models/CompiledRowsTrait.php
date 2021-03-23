<?php namespace App\Models;

use App\Entities\Job;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use Tatter\Permits\Traits\PermitsTrait;
use Tatter\Relations\Traits\ModelTrait;
use Tatter\Workflows\Entities\Job as BaseJob;
use Tatter\Workflows\Models\JobModel as BaseJobModel;

/**
 * Compiled Rows Trait
 *
 * Adds customized row fetching and caching to models.
 *
 * @mixin BaseModel
 */
trait CompiledRowsTrait
{
	/**
	 * Fetch or build the compiled rows for browsing,
	 * applying filters, and sorting.
	 *
	 * @return array[]
	 */
	abstract protected function fetchCompiledRows(): array;

	/**
	 * Removes cached Job rows.
	 *
	 * @return $this
	 */
	public function clearCompiledRows(): self
	{
		cache()->delete($this->table . 'rows');

		return $this;
	}

	/**
	 * Fetch or build the rows for browsing,
	 * applying filters and sorting.
	 *
	 * @param callable|null $filter
	 * @param string $sort
	 * @param bool $ascending
	 *
	 * @return array[]
	 */
	public function getCompiledRows(callable $filter = null, string $sort = 'id', bool $ascending = true): array
	{
		if (! $rows = cache($this->table . 'rows'))
		{
			// Pull all the data
			$result = $this->fetchCompiledRows();

			// Process into rows
			$rows = [];
			foreach ($result as $row)
			{
				// Only keep the first match (in case of from multiple joins)
				if (isset($rows[$row['id']]))
				{
					continue;
				}

				$rows[$row['id']] = $row;
			}

			// Convert timestamps to Time
			$fields = $this->getTimestampFields();
			$rows   = array_map(function ($row) use ($fields) {
				foreach ($fields as $field)
				{
					if (isset($row[$field]))
					{
						$row[$field] = new Time($row[$field]);
					}
				}

				return $row;
			}, $rows);

			// Cache the rows
			$rows = array_values($rows);
			cache()->save($this->table . 'rows', $rows, HOUR);
		}

		// Filter the array with the callable, or `null` which removes empties
		$rows = $filter ? array_filter($rows, $filter) : array_filter($rows);

		// Short circuit for unsortable results
		if (count($rows) < 2)
		{
			return $rows;
		}

		// Check for a valid sort request
		if (array_key_exists($sort, reset($rows)))
		{
			usort($rows, function ($row1, $row2) use ($sort, $ascending) {
				return $ascending
					? $row1[$sort] <=> $row2[$sort]
					: $row2[$sort] <=> $row1[$sort];
			});
		}

		return $rows;
	}

	/**
	 * Returns an array of all fields that should
	 * be converted to Time objects.
	 *
	 * @return string[]
	 */
	private function getTimestampFields(): array
	{
		$fields = [];

		if ($this->useTimestamps)
		{
			if ($this->createdField)
			{
				$fields[] = $this->createdField;
			}
			if ($this->updatedField)
			{
				$fields[] = $this->updatedField;
			}
		}

		if ($this->tempUseSoftDeletes && $this->deletedField)
		{
			$fields[] = $this->deletedField;
		}

		return $fields;
	}
}

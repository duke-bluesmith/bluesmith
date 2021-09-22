<?php

namespace App\Database\Seeds;

use Tatter\Themes\Database\Seeds\ThemeSeeder as BaseSeeder;
use Tatter\Themes\Models\ThemeModel;

/**
 * Theme Seeder
 *
 * Extends the library's seeder to include
 * additional themes packaged with this app.
 */
class ThemeSeeder extends BaseSeeder
{
	public function run()
	{
		parent::run();

		$rows = [
			[
				'name'        => 'Dark',
				'path'        => 'themes/dark',
				'description' => 'Sometimes there is no darker place than our thoughts, the moonless midnight of the mind.',
				'dark'        => 1,
			],
			[
				'name'        => 'Light',
				'path'        => 'themes/light',
				'description' => 'Low calorie, gluten-free',
				'dark'        => 0,
			],
		];

		foreach ($rows as $row)
		{
			if (! model(ThemeModel::class)->where('name', $row['name'])->first())
			{
				model(ThemeModel::class)->insert($row);
			}
		}
	}
}

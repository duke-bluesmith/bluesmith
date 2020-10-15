<?php namespace App\Database\Seeds;

use App\Models\PageModel;

class PageSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		// Add rows for required pages
		$pages = new PageModel();
		foreach (['home', 'options', 'terms', 'privacy'] as $name)
		{
			$page = $pages->where('name', $name)->first();

			if (empty($page))
			{
				$row = [
					'name'    => $name,
					'content' => view("_examples/{$name}", [], ['debug' => false]),
				];

				$pages->insert($row);
			}
		}
	}
}

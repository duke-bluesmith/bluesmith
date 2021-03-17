<?php namespace App\Controllers;

use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
	public function show($name = 'home')
	{
		if (! $page = model(PageModel::class)->where('name', $name)->first())
		{
			throw PageNotFoundException::forPageNotFound();
		}

		// Check for a specified view file
		$path = config('Paths')->viewDirectory . '/pages/' . strtolower($page->name) . '.php';
		if (is_file($path))
		{
			return view('pages/' . strtolower($page->name), ['content' => $page->content, 'menu' => $page->name]);
		}

		// Otherwise use the generic one		
		return view('pages/show', ['content' => $page->content, 'menu' => $page->name]);
	}
}

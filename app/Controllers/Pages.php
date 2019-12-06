<?php namespace App\Controllers;

use App\Models\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
	public function show($page = 'home')
	{
		$pages = new PageModel();
		$page = $pages->where('name', $page)->first();
		
		if (empty($page))
		{
			 throw PageNotFoundException::forPageNotFound();
		}
		
		// Check for a view file
		$viewDirectory = config('Paths')->viewDirectory ?? '';
		if ($viewDirectory && is_file("{$viewDirectory}/pages/{$page->name}"))
		{
			return view("{$viewDirectory}/pages/{$page->name}", ['content' => $page->content, 'menu' => $page->name]);
		}
		
		// Otherwise use the generic one		
		return view('pages/show', ['content' => $page->content, 'menu' => $page->name]);
	}
}

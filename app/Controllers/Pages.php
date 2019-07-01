<?php namespace App\Controllers;

use App\Models\Manage\PageModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
	public function show($page = 'home')
	{
		$pages = new PageModel();
		$page = $pages->where('name', $page)->first();
		
		if (empty($page))
			 throw PageNotFoundException::forPageNotFound();
		
		return view('pages/show', ['content' => $page->content, 'menu' => $page->name]);
	}
}

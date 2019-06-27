<?php namespace App\Controllers;

use App\Models\Manage\PageModel;

class Home extends BaseController
{
	public function index()
	{
		$pages = new PageModel();
		$page = $pages->where('name', 'Home')->first();
		
		return view('home', ['content' => $page->content]);
	}
}

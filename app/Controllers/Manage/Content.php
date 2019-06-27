<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\Manage\PageModel;

class Content extends BaseController
{	
	public function page($name = 'Home')
	{
		$pages = new PageModel();
		
		// Check for form submission
		if ($post = $this->request->getPost()):
			$page = $pages->where('name', $post['name'])->first();
			
			$page->content = $post['content'];
			$pages->save($page);
			
			alert('success', "'{$page->name}' updated.");
			
		// Load current values		
		else:
			$page = $pages->where('name', $name)->first();
		endif;		
		
		$data = [
			'name'    => $page->name,
			'content' => $page->content,
		];
		return view('manage/content/page', $data);
	}
}

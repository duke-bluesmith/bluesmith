<?php

namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\PageModel;

class Content extends BaseController
{
    /**
     * @var PageModel
     */
    protected $model;

    /**
     * Preloads the Page model
     */
    public function __construct()
    {
        $this->model = new PageModel();
    }

    /**
     * Loads dynamic page content from the database
     *
     * @param mixed $name
     */
    public function page($name = 'home'): string
    {
        // Check for form submission
        if ($post = $this->request->getPost()) {
            $page          = $this->model->where('name', $post['name'])->first();
            $page->content = $post['content'];

            $this->model->save($page);

            alert('success', "'{$page->name}' page updated.");
        }
        // Load current values
        else {
            $page = $this->model->where('name', $name)->first();
        }

        $data = [
            'name'    => $page->name,
            'content' => $page->content,
        ];

        return view('content/page', $data);
    }

    /**
     * Displays or processes individual settings related to site branding
     */
    public function branding(): string
    {
    	$preferences = config('Preferences');
        helper('date');

        // Check for form submission
        if ($post = $this->request->getPost()) {
            foreach ($post as $name => $content) {
            	if (property_exists($preferences, $name)) {
	                preference($name, $content);
	            }
            }

            if ($this->request->isAJAX()) {
                echo 'success';

                return '';
            }

            alert('success', 'Settings updated.');
        }

        return view('content/branding', $data);
    }
}

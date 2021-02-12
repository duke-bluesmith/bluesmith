<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		// return view('manage/dashboard');
		return redirect()->to(site_url('manage/jobs/staff'));
	}
}

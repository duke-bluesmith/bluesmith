<?php namespace App\Controllers;

use Tatter\Workflows\Models\JobModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Account extends BaseController
{
	// Displays a list of jobs for the current user
	public function jobs()
	{
		return view('account/jobs', ['jobs' => user()->jobs]);
	}
}

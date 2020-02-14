<?php namespace App\Controllers;

use Tatter\Workflows\Models\JobModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Account extends BaseController
{
	use \ProjectTests\Support\Traits\FakerTrait;

	// Displays a list of jobs for the current user
	public function jobs()
	{
		return view('account/jobs', ['jobs' => user()->jobs]);
	}

	public function generate()
	{
		$this->db = db_connect();

		$this->fakerSetUp();
		$this->fullFake();

		return redirect()->to(base_url())->with('message', 'Faked data generated');
	}
}

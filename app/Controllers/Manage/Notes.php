<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\NoteModel;
use CodeIgniter\HTTP\RedirectResponse;

class Notes extends BaseController
{
	/**
	 * Adds a Note to a Job
	 *
	 * @return RedirectResponse
	 */
	public function add(): RedirectResponse
	{
		$data            = $this->request->getPost();
		$data['user_id'] = user()->id;

		// Create the Note
		if (! model(NoteModel::class)->insert($data))
		{
			return redirect()
				->back()
				->withInput()
				->with('errors', model(NoteModel::class)->errors());
		}

		return redirect()->back();
	}
}

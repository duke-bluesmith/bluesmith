<?php namespace App\Actions;

use App\BaseAction;
use App\Models\NoteModel;
use CodeIgniter\HTTP\RedirectResponse;

class PrintAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Process',
		'name'     => 'Print',
		'uid'      => 'print',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-cubes',
		'summary'  => 'Staff prints objects',
	];
	
	public function get()
	{
		// Load the helpers
		helper(['currency', 'form', 'number']);

		return view('actions/print', [
			'action'   => $this->attributes['name'],
			'job'      => $this->job,
			'estimate' => $this->job->getEstimate(),
		]);
	}

	/**
	 * Marks the job as printed and this Action complete.
	 *
	 * @return bool
	 */
	public function post()
	{
		// End the action
		return true;
	}

	/**
	 * Adds a Note.
	 *
	 * @return RedirectResponse
	 */
	public function put(): RedirectResponse
	{
		$data = service('request')->getPost();

		$data['job_id']  = $this->job->id;
		$data['user_id'] = user()->id;

		// Create the Note
		if (! model(NoteModel::class)->insert($data))
		{
			return redirect()->back()->withInput()->with('error', implode(' ', model(NoteModel::class)->errors()));
		}

		return redirect()->back();
	}
}

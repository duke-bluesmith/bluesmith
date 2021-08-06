<?php namespace App\Actions;

use App\BaseAction;
use App\Models\NoteModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

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
		'header'   => 'Print',
		'button'   => 'Printing Complete',
	];

	/**
	 * Displays the Job print prompt.
	 *
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface
	{
		return $this->render('actions/print', [
			'estimate' => $this->job->getEstimate(),
		]);
	}

	/**
	 * Marks the job as printed and this Action complete.
	 *
	 * @return null
	 */
	public function post(): ?ResponseInterface
	{
		// End the action
		return null;
	}

	/**
	 * Adds a Note.
	 *
	 * @return RedirectResponse
	 */
	public function put(): ?ResponseInterface
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

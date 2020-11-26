<?php namespace App\Actions;

use App\BaseAction;

class ApproveAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Assess',
		'name'     => 'Approve',
		'uid'      => 'approve',
		'role'     => 'user',
		'icon'     => 'fas fa-thumbs-up',
		'summary'  => 'Client approves the estimate',
	];

	/**
	 * Displays the Charges and form for
	 * accepting the estimate Ledger.
	 *
	 * @return string
	 */
	public function get()
	{
		return view('actions/approve', [
			'job'      => $this->job,
			'estimate' => $this->job->getEstimate(),
		]);
	}

	/**
	 * Processes the acceptance.
	 *
	 * @return bool
	 */
	public function post(): bool
	{
		// End the action
		return true;
	}
}

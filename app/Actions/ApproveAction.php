<?php

namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\ResponseInterface;

class ApproveAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Assess',
		'name'     => 'Approve',
		'uid'      => 'approve',
		'role'     => '',
		'icon'     => 'fas fa-thumbs-up',
		'summary'  => 'Client approves the estimate',
		'header'   => 'Approval',
		'button'   => 'Approve Estimate',
	];

	/**
	 * Displays the Charges and form for
	 * accepting the estimate Ledger.
	 */
	public function get(): ResponseInterface
	{
		return $this->render('actions/approve', [
			'estimate' => $this->job->getEstimate(),
		]);
	}

	/**
	 * Processes the acceptance.
	 *
	 * @return null
	 */
	public function post(): ?ResponseInterface
	{
		// End the action
		return null;
	}
}

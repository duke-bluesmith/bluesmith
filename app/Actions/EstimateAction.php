<?php namespace App\Actions;

use App\BaseAction;
use App\Libraries\Mailer;
use App\Models\LedgerModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class EstimateAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Assess',
		'name'     => 'Estimate',
		'uid'      => 'estimate',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-balance-scale-right',
		'summary'  => 'Staff issues estimate',
	];

	/**
	 * Displays the Charges and form for sending
	 * the estimate Ledger.
	 *
	 * @return string
	 */
	public function get()
	{
		return view('actions/estimate', [
			'job'      => $this->job,
			'estimate' => $this->job->getEstimate(),
		]);
	}

	/**
	 * Processes form data and sends the Estimate
	 * Email to each selected user.
	 *
	 * @return RedirectResponse|bool
	 */
	public function post()
	{
		// Update the description and reload the estimate Ledger
		model(LedgerModel::class)->update($this->job->estimate->id, [
			'description' => service('request')->getPost('description'),
		]);
		$ledger = model(LedgerModel::class)->find($this->job->estimate->id);

		// Verify each user and grab their email address
		$recipients = [];
		foreach (service('request')->getPost('users') ?? [] as $userId)
		{
			if (! is_numeric($userId))
			{
				continue;			
			}

			if ($user = model(UserModel::class)->first($userId))
			{
				$recipients[] = $user->email;
			}
			else
			{
				alert('warning', 'Unable to locate user #' . $userId);
			}
		}

		if ($recipients)
		{
			// Send the email
			Mailer::forEstimate($recipients, $this->job, $ledger);
		}

		// End the action
		return true;
	}
}

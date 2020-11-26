<?php namespace App\Actions;

use App\BaseAction;
use App\Models\ChargeModel;
use App\Models\LedgerModel;
use CodeIgniter\HTTP\RedirectResponse;

class InvoiceAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Complete',
		'name'     => 'Invoice',
		'uid'      => 'invoice',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-receipt',
		'summary'  => 'Staff issues an invoice for actual charges',
	];

	public function get()
	{
		return view('actions/invoice', [
			'job'     => $this->job,
			'invoice' => $this->job->getInvoice(true),
		]);
	}

	public function post()
	{
		$data = service('request')->getPost();

		// End the action
		return true;
	}

	public function put()
	{

	}

	/**
	 * Create the initial invoice Ledger from the estimate Ledger.
	 */
	public function up()
	{
		// If there is no estimate then create a new one
		if (! $this->job->getInvoice())
		{
			$ledgerId = model(LedgerModel::class)->insert([
				'job_id'   => $this->job->id,
				'estimate' => 0,
			]);

			// Add Charges from the estimate
			foreach ($this->job->estimate->charges as $charge)
			{
				model(ChargeModel::class)->insert([
					'ledger_id' => $ledgerId,
					'name'      => $charge->name,
					'price'     => $charge->price,
					'quantity'  => $charge->quantity,
				]);
			}
		}
	}
}

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

	/**
	 * Ends the Action
	 *
	 * @return bool
	 */
	public function post(): bool
	{
		return true;
	}

	/**
	 * Adds a Charge to the invoice Ledger.
	 *
	 * @return RedirectResponse
	 */
	public function put()
	{
		$data = service('request')->getPost();

		// Convert the input into fractional money units
		$data['price']     = scaled_to_price($data['price']);
		$data['ledger_id'] = $this->job->invoice->id;

		if (empty($data['quantity']))
		{
			unset($data['quantity']);
		}

		// Add the Charge
		if (! model(ChargeModel::class)->insert($data))
		{
			return redirect()->back()->withInput()->with('error', implode(' ', model(ChargeModel::class)->errors()));
		}

		return redirect()->back();
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

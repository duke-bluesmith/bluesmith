<?php namespace App\Actions;

use App\BaseAction;
use App\Models\ChargeModel;
use App\Models\LedgerModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

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
		'header'   => 'Create Invoice',
		'button'   => 'Send Invoice',
	];

	/**
	 * Displays the invoice form.
	 *
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface
	{
		return $this->render('actions/invoice', [
			'invoice' => $this->job->getInvoice(true),
		]);
	}

	/**
	 * Ends the Action
	 *
	 * @return null
	 */
	public function post(): ?ResponseInterface
	{
		return null;
	}

	/**
	 * Removes a single Charge.
	 *
	 * @return RedirectResponse
	 */
	public function delete(): ResponseInterface
	{
		if ($chargeId = service('request')->getPost('charge_id'))
		{
			model(ChargeModel::class)->delete($chargeId);
			alert('warning', 'Charge removed.');
		}

		return redirect()->back();
	}

	/**
	 * Adds a Charge to the invoice Ledger.
	 *
	 * @return RedirectResponse
	 */
	public function put(): ResponseInterface
	{
		$data = service('request')->getPost();

		if (! isset($data['amount']))
		{
			return redirect()->back()->withInput()->with('error', 'You must enter a price!');
		}

		// Convert the input into fractional money units
		$data['amount']    = scaled_to_price($data['amount']);
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
			foreach ($this->job->getEstimate(true)->charges ?? [] as $charge)
			{
				model(ChargeModel::class)->insert([
					'ledger_id' => $ledgerId,
					'name'      => $charge->name,
					'amount'    => $charge->amount,
					'quantity'  => $charge->quantity,
				]);
			}
		}
	}
}

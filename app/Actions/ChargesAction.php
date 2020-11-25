<?php namespace App\Actions;

use App\BaseAction;
use App\Models\ChargeModel;
use App\Models\LedgerModel;
use CodeIgniter\HTTP\RedirectResponse;

class ChargesAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Assess',
		'name'     => 'Charges',
		'uid'      => 'charges',
		'role'     => 'manageJobs',
		'icon'     => 'fas fa-file-invoice-dollar',
		'summary'  => 'Staff reviews submission and sets charges',
	];

	/**
	 * Load the helpers
	 */
	public function __construct()
	{
		parent::__construct();

		helper(['currency', 'form', 'number']);
	}

	/**
	 * Displays the form for modifying Charges
	 * on the estimate Ledger.
	 *
	 * @return string
	 */
	public function get()
	{
		// Build out the clickable charge items for the "Details" aside
		$items = [
			[
				'name' => $this->job->material->method->name,
				'quantity' => null,
			],
			[
				'name'     => $this->job->material->name,
				'quantity' => 1,
			]
		];
		foreach ($this->job->options as $option)
		{
			$items[] = [
				'name'     => $option->summary,
				'quantity' => null,
			];
		}

		return view('actions/charges/index', [
			'job'      => $this->job,
			'estimate' => $this->job->getEstimate(true),
			'items'    => $items,
		]);
	}

	/**
	 * Denotes that all Charges are created.
	 *
	 * @return bool
	 */
	public function post(): bool
	{
		return true;
	}

	/**
	 * Removes a single Charge.
	 *
	 * @return RedirectResponse
	 */
	public function delete(): RedirectResponse
	{
		if ($chargeId = service('request')->getPost('charge_id'))
		{
			model(ChargeModel::class)->delete($chargeId);
			alert('warning', 'Charge removed.');
		}

		return redirect()->back();
	}

	/**
	 * Adds a Charge to the estimate Ledger.
	 *
	 * @return RedirectResponse
	 */
	public function put(): RedirectResponse
	{
		$data = service('request')->getPost();

		// Convert the input into fractional money units
		helper('currency');
		$data['price']     = scaled_to_price($data['price']);
		$data['ledger_id'] = $this->job->estimate->id;

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
	 * Runs when a job progresses forward through the workflow
	 */
	public function up()
	{
		// If there is no estimate then create a new one
		if (! $this->job->getEstimate())
		{
			model(LedgerModel::class)->insert([
				'job_id'   => $this->job->id,
				'estimate' => 1,
			]);
		}
	}
}

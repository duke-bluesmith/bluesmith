<?php namespace App\Actions;

use App\BaseAction;
use App\BaseMerchant;
use App\Exceptions\PaymentException;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

class PaymentAction extends BaseAction
{
	/**
	 * @var array<string, string>
	 */
	public $attributes = [
		'category' => 'Complete',
		'name'     => 'Payment',
		'uid'      => 'payment',
		'role'     => 'user',
		'icon'     => 'fas fa-money-check',
		'summary'  => 'Client submits payment for charges',
	];

	/**
	 * Displays the payment details from the invoice Ledger
	 * and a selectable list of user-eligible Merchants.
	 *
	 * @return string
	 */
	public function get(): string
	{
		// Load Merchants and filter by eligibility
		$merchants = [];
		foreach (service('handlers', 'Merchants')->findAll() as $class)
		{
			$merchant = new $class();
			if ($merchant->eligible(user()))
			{
				$merchants[] = $merchant;
			}
		}

		return view('actions/payment/index', [
			'job'       => $this->job,
			'invoice'   => $this->job->getInvoice(),
			'merchants' => $merchants,
		]);
	}

	/**
	 * Indicates payment is complete and finishes the Action.
	 *
	 * @return string
	 */
	public function post()
	{
		return true;
	}

	/**
	 * Returns the Merchant-specific request (usually a form or redirect)
	 *
	 * @return ResponseInterface
	 */
	public function put(): ResponseInterface
	{
		return $this->getMerchant()->request($this->job->getInvoice());
	}

	/**
	 * Processes payment from put() with the Merchant
	 *
	 * @return RedirectResponse|string
	 */
	public function patch()
	{
		$merchant = $this->getMerchant();
		$data     = service('request')->getPost();
		$amount   = scaled_to_price($data['amount']);

		// Attempt to authorize with the Merchant
		$payment = $merchant->authorize(user(), $this->job->getInvoice(), $amount, $data);
		if (! is_null($payment->code))
		{
			$message = $payment->reason ?: lang('Actions.unauthorized', $this->attributes['code']);
			return redirect()->back()->withInput()->with('error', $message);
		}

		// Payment authorized! Proceed with the charge
		$payment = $merchant->complete($payment);
		if ($payment->code !== 0)
		{
			$message = $payment->reason ?: lang('Actions.failure', $this->attributes['code']);
			return redirect()->back()->withInput()->with('error', $message);
		}

		alert('success', lang(
			'Payment.success',
			[price_to_currency($amount)]
		));
		return $this->get();
	}

	/**
	 * Initializes a Merchant from its posted UID
	 *
	 * @return BaseMerchant
	 */
	protected function getMerchant(): BaseMerchant
	{
		$name  = service('request')->getPost('merchant');
		$class = service('handlers', 'Merchants')->find($name);

		return new $class();
	}
}

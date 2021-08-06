<?php namespace App\Actions;

use App\BaseAction;
use App\BaseMerchant;
use App\Entities\User;
use App\Exceptions\PaymentException;
use App\Models\PaymentModel;
use CodeIgniter\HTTP\RedirectResponse;
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
		'role'     => '',
		'icon'     => 'fas fa-money-check',
		'summary'  => 'Client submits payment for charges',
		'header'   => 'Submit Payment',
		'button'   => 'Done Paying',
	];

	/**
	 * Displays the payment details from the invoice Ledger
	 * and a selectable list of user-eligible Merchants.
	 *
	 * @return ResponseInterface|null
	 */
	public function get(): ?ResponseInterface
	{
		/** @var User $user */
		$user = user();

		// Load Merchants and filter by eligibility
		$merchants = [];
		foreach (service('handlers', 'Merchants')->findAll() as $class)
		{
			$merchant = new $class();
			if ($merchant->eligible($user))
			{
				$merchants[] = $merchant;
			}
		}

		return $this->render('actions/payment', [
			'invoice'   => $this->job->getInvoice(),
			'merchants' => $merchants,
		]);
	}

	/**
	 * Indicates payment is complete and finishes the Action.
	 *
	 * @return RedirectResponse|null
	 */
	public function post(): ?ResponseInterface
	{
		if ($this->job->invoice->due > 0)
		{
			return redirect()->back()->with('error', lang('Payment.unpaid'));
		}

		return null;
	}

	/**
	 * Begins a Payment with info from get()
	 *
	 * @return ResponseInterface
	 */
	public function put(): ?ResponseInterface
	{
		/** @var User $user */
		$user = user();
		$data = service('request')->getPost();

		// Locate the Merchant
		if (empty($data['merchant']))
		{
			return redirect()->back()->withInput()->with('error', 'Please select a payment method.');
		}
		if (! $class = service('handlers', 'Merchants')->find($data['merchant']))
		{
			$message = 'Unable to locate payment method "' . $data['merchant'] . '"';
			log_message('error', $message);
			return redirect()->back()->withInput()->with('error', $message);
		}
		$merchant = new $class();

		// Verify Merchant eligibility
		if (! $merchant->eligible($user))
		{
			return redirect()->back()->withInput()->with('error', 'You are not eligible for payments with ' . $merchant->name);		
		}

		// Validate amounts
		$due    = $this->job->invoice->getDue();
		$amount = scaled_to_price($data['amount']);

		if ($amount < 1)
		{
			return redirect()->back()->withInput()->with('error', 'Payment amount must be more than 0.');
		}
		if ($amount > $due)
		{
			return redirect()->back()->withInput()->with('error', 'Payment amount should not be more than ' . price_to_currency($due));
		}

		// Attempt to authorize with the Merchant
		$payment = $merchant->authorize($user, $this->job->getInvoice(), $amount, $data);
		if (! is_null($payment->code))
		{
			$message = $payment->reason ?: lang('Payment.unauthorized', [$this->attributes['code']]);
			return redirect()->back()->withInput()->with('error', $message);
		}

		// Payment authorized! Request the payment
		$result = $merchant->request($payment);

		// If $result was a response then more processing is needed, probably a redirect or form
		if ($result instanceof ResponseInterface)
		{
			return $result;
		}

		// Otherwise $result was null and Payment is done, check for failures
		$payment = model(PaymentModel::class)->find($payment->id);
		if ($payment->code !== 0)
		{
			$message = $payment->reason ?: lang('Payment.failure', [$this->attributes['code']]);
			return redirect()->back()->withInput()->with('error', $message);
		}

		alert('success', lang(
			'Payment.success',
			[price_to_currency($amount)]
		));

		// Send back to get()
		return redirect()->to(current_url());
	}
}

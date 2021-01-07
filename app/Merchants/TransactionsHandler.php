<?php namespace App\Merchants;

use App\BaseMerchant;
use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Models\PaymentModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class TransactionsHandler extends BaseMerchant
{
	/**
	 * Attributes for Tatter\Handlers
	 *
	 * @var array<string, mixed>      
	 */
	public $attributes = [
		'name'    => 'Transactions',
		'uid'     => 'transactions',
		'icon'    => 'fas fa-cookie-bite',
		'summary' => 'Internal currency credit/debit tracking.',
	];

	/**
	 * Use the language setting to override the name
	 */
	public function __construct()
	{
		$this->attributes['name'] = lang('Pub.transactions');

		parent::__construct();
	}

	/**
	 * Checks a User for eligibility to use this Merchant.
	 *
	 * @param User $user The User to check
	 *
	 * @return bool
	 */
	public function eligible(User $user): bool
	{
		return ! empty($user->balance);
	}

	/**
	 * Initiates a request for payment, returning a response
	 * (usually a form or redirect link)
	 *
	 * @param Ledger $invoice The invoice Ledger to make payment towards
	 *
	 * @return ResponseInterface
	 */
	public function request(Ledger $invoice): ResponseInterface
	{
		return service('response', config('App'))->setBody(
			view('actions/payment/transactions', ['invoice' => $invoice])
		);
	}

	/**
	 * Performs pre-payment verification and starts the Payment record.
	 *
	 * @param User $user      The User making the payment
	 * @param Ledger $invoice The invoice Ledger to make payment towards
	 * @param int $amount     Amount to charge in fractional money units
	 * @param array $data     Additional data for the gateway, usually from request()
	 *
	 * @return Payment The resulting record of the authorized Payment
	 */
	public function authorize(User $user, Ledger $invoice, int $amount, array $data = []): Payment
	{
		$row = [
			'ledger_id' => $invoice->id,
			'user_id'   => $user->id,
			'amount'    => $amount,
			'class'     => static::class,
		];

		// Make sure User has enough balance
		if ($user->balance < $amount)
		{
			$row['code']   = 413;
			$row['reason'] = lang('Payment.insufficient', [
				price_to_currency($user->balance),
				price_to_currency($amount),
			]);
		}

		if (! $id = model(PaymentModel::class)->insert($row))
		{
			$error = implode(' ', model(PaymentModel::class)->error());
			throw new \RuntimeException($error);
		}

		return model(PaymentModel::class)->find($id);
	}

	/**
	 * Confirms the Payment with the Merchant. May send the user off
	 * to complete processing.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 *
	 * @return ResponseInterface|null
	 */
	public function confirm(Payment $payment): ?ResponseInterface
	{
		return null;
	}

	/**
	 * Does the actual processing of the preauthorized Payment.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 * @param array $data      Additional data for the gateway, usually from confirm()
	 *
	 * @return Payment The potentially-updated Payment record
	 */
	public function complete(Payment $payment, array $data = []): Payment
	{
		if (! $user = model(UserModel::class)->find($payment->user_id))
		{
			throw new \RuntimeException('Unable to locate user for Payment ' . $payment->id);
		}

		$transactionId = model(TransactionModel::class)->debit(
			$user,
			$payment->amount,
			'Payment ' . $payment->id . ' towards Ledger ' . $payment->ledger_id
		);

		// Update the Payment with the Transaction
		model(PaymentModel::class)->update($payment->id, [
			'code'      => 0,
			'reference' => $transactionId,
		]);

		return model(PaymentModel::class)->find($payment->id);
	}
}

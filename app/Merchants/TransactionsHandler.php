<?php namespace App\Merchants;

use App\BaseMerchant;
use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Exceptions\PaymentException;
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
		'icon'    => 'fas cookie-bite',
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
	 * Initiates a request for payment, returning a response
	 * (usually a form or redirect link)
	 *
	 * @param Ledger $ledger The invoice Ledger to make payment towards
	 *
	 * @return ResponseInterface
	 */
	public function request(Ledger $ledger): ResponseInterface
	{

	}

	/**
	 * Performs pre-payment verification and starts the Payment record.
	 *
	 * @param User $user       The User making the payment
	 * @param Ledger $ledger   The invoice Ledger to make payment towards
	 * @param array $data      Additional data for the gateway, usually from request()
	 * @param int|null $amount Optional amount to pay instead of the Ledger total
	 *
	 * @return Payment The resulting record of the Payment
	 */
	public function authorize(User $user, Ledger $ledger, array $data = [], int $amount = null): Payment
	{

	}

	/**
	 * Does the actual proessing of the preauthorized Payment.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 *
	 * @return Payment The potentially-updated Payment record
	 *
	 * @throws PaymentException For any failure
	 */
	public function complete(Payment $payment): Payment
	{

	}
}

<?php namespace App;

use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Models\PaymentModel;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Handlers\BaseHandler;

/**
 * Base Merchant Abstract Class
 *
 * Provides common method basis for payment processing.
 * Each Merchant should correspond with its respective
 * payment gateway to handle authorization and processing.
 *
 * Methods should not throw exceptions (except for grievous
 * mistakes), but rather create/update a Payment object with
 * the relevant failure code and corresponding reason.
 * Methods in this class are in their logical order of
 * execution.
 *
 * @see PaymentAction
 */
abstract class BaseMerchant extends BaseHandler
{
	/**
	 * Attributes for Tatter\Handlers
	 *
	 * @var array<string, mixed>      
	 */
	public $attributes;

	/**
	 * Default set of attributes
	 *
	 * @var array<string, mixed>
	 */
	private $defaults = [
		'name'    => '',
		'uid'     => '',
		'icon'    => 'fas money-bill-wave',
		'summary' => '',
	];

	/**
	 * Instance of the PaymentModel to use
	 *
	 * @var PaymentModel
	 */
	protected $model;

	/**
	 * Merges default attributes with child and initializes the PaymentModel
	 */
	public function __construct(PaymentModel $model = null)
	{
		$this->attributes = array_merge($this->defaults, $this->attributes);
		$this->model      = $model ?? model(PaymentModel::class);
	}

	/**
	 * Checks a User for eligibility to use this Merchant.
	 *
	 * @param User $user The User to check
	 *
	 * @return bool
	 */
	abstract public function eligible(User $user): bool;

	/**
	 * Initiates a request for payment, returning a response
	 * (usually a form or redirect)
	 *
	 * @param Ledger $invoice The invoice Ledger to make payment towards
	 *
	 * @return ResponseInterface
	 */
	abstract public function request(Ledger $invoice): ResponseInterface;

	/**
	 * Performs pre-payment verification and starts the Payment record.
	 *
	 * @param User $user     The User making the payment
	 * @param Ledger $invoice The invoice Ledger to make payment towards
	 * @param int $amount    Amount to charge in fractional money units
	 * @param array $data    Additional data for the gateway, usually from request()
	 *
	 * @return Payment The resulting record of the authorized Payment
	 */
	abstract public function authorize(User $user, Ledger $invoice, int $amount, array $data = []): Payment;

	/**
	 * Confirms the Payment with the Merchant. May send the user off
	 * to complete processing.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 *
	 * @return ResponseInterface|null
	 */
	abstract public function confirm(Payment $payment): ?ResponseInterface;

	/**
	 * Does the actual processing of the preauthorized Payment.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 * @param array $data      Additional data for the gateway, usually from confirm()
	 *
	 * @return Payment The updated Payment record
	 */
	abstract public function complete(Payment $payment, array $data = []): Payment;
}

<?php namespace App;

use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Exceptions\PaymentException;
use App\Models\PaymentModel;
use App\Models\PaymentStatusModel;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Handlers\BaseHandler;

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
	 * @var PaymentStatusModel
	 */
	protected $statuses;

	/**
	 * Merges default attributes with child and initializes the models
	 */
	public function __construct(PaymentModel $model = null, PaymentStatusModel $statuses = null)
	{
		$this->attributes = array_merge($this->defaults, $this->attributes);
		$this->model      = $model ?? model(PaymentModel::class);
		$this->statuses   = $statuses ?? model(PaymentStatusModel::class);
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
	 * (usually a form or redirect link)
	 *
	 * @param Ledger $ledger The invoice Ledger to make payment towards
	 *
	 * @return ResponseInterface
	 */
	abstract public function request(Ledger $ledger): ResponseInterface;

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
	abstract public function authorize(User $user, Ledger $ledger, array $data = [], int $amount = null): Payment;

	/**
	 * Does the actual proessing of the preauthorized Payment.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 *
	 * @return Payment The potentially-updated Payment record
	 *
	 * @throws PaymentException For any failure
	 */
	abstract public function complete(Payment $payment): Payment;
}

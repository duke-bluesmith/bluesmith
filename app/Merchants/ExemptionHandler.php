<?php namespace App\Merchants;

use App\BaseMerchant;
use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Models\PaymentModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Authorization\GroupModel;
use RuntimeException;

class ExemptionHandler extends BaseMerchant
{
	/**
	 * Attributes for Tatter\Handlers
	 *
	 * @var array<string, mixed>      
	 */
	public $attributes = [
		'name'    => 'Exemption',
		'uid'     => 'exemption',
		'icon'    => 'fas fa-user-tie',
		'summary' => 'Exempt an amount from payment.',
	];

	/**
	 * Checks a User for eligibility to use this Merchant.
	 *
	 * @param User $user The User to check
	 *
	 * @return bool
	 */
	public function eligible(User $user): bool
	{
		if (! $groups = model(GroupModel::class)->getGroupsForUser($user->id))
		{
			return false;
		}

		return in_array('Administrators', array_column($groups, 'name'));
	}

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
	public function authorize(User $user, Ledger $invoice, int $amount, array $data = []): Payment
	{
		return $this->createPayment($user, $invoice, $amount);
	}

	/**
	 * Initiates a gateway request for payment with the Merchant,
	 * returning a response (usually a form or redirect).
	 * Gateways that confirm internally may update the
	 * Payment and return null to signify completion.
	 *
	 * @param Payment $payment The pre-authorized Payment from authorize()
	 *
	 * @return ResponseInterface|null
	 */
	public function request(Payment $payment): ?ResponseInterface
	{
		if (! $user = model(UserModel::class)->find($payment->user_id))
		{
			throw new RuntimeException('Unable to locate User for Payment ' . $payment->id);
		}

		// Update the Payment
		model(PaymentModel::class)->update($payment->id, [
			'code'      => 0,
			'reference' => $user->id,
		]);

		return null;
	}
}

<?php

namespace App;

use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Models\PaymentModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

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
 *
 * Methods in this class are in their logical order of
 * execution.
 *
 * @see PaymentAction
 */
abstract class BaseMerchant
{
    public const HANDLER_ID = '';

    /**
     * Instance of the PaymentModel to use
     *
     * @var PaymentModel
     */
    protected $payments;

    /**
     * Initializes the PaymentModel
     */
    public function __construct(?PaymentModel $payments = null)
    {
        $this->payments = $payments ?? model(PaymentModel::class);
    }

    /**
     * Creates a new Payment with supplied criteria.
     * Usually called during authorize().
     *
     * @param User     $user    The User making the payment
     * @param Ledger   $invoice The invoice Ledger to make payment towards
     * @param int      $amount  Amount to charge in fractional money units
     * @param int|null $code    Error code if something went wrong
     * @param string   $reason  Optional reason to explain error code
     *
     * @throws RuntimeException
     *
     * @return Payment The new Payment
     */
    protected function createPayment(User $user, Ledger $invoice, int $amount, ?int $code = null, string $reason = ''): Payment
    {
        $result = $this->payments->insert([
            'ledger_id' => $invoice->id,
            'user_id'   => $user->id,
            'amount'    => $amount,
            'class'     => static::class,
            'code'      => $code,
            'reason'    => $reason,
        ]);

        if (! $result) {
            $error = implode(' ', model(PaymentModel::class)->errors());

            throw new RuntimeException($error);
        }

        // Return the new version from the database
        return $this->payments->find($result);
    }

    /**
     * Fetches a User's balance, if supported.
     *
     * @param User $user The User to check
     *
     * @return int|null User balance in fractional money units, or null for "unsupported"
     */
    public function balance(User $user): ?int
    {
        return null;
    }

    /**
     * Checks a User for eligibility to use this Merchant.
     *
     * @param User $user The User to check
     */
    public function eligible(User $user): bool
    {
        $balance = $this->balance($user);

        return ($balance === null) || ($balance > 0);
    }

    /**
     * Returns this Merchant's display name.
     */
    abstract public function getName(): string;

    /**
     * Returns this Merchant's icon class.
     */
    abstract public function getIcon(): string;

    /**
     * Returns this Merchant's summary.
     */
    abstract public function getSummary(): string;

    /**
     * Performs pre-payment verification and calls
     * createPayment() to begin the Payment record.
     *
     * @param User   $user    The User making the payment
     * @param Ledger $invoice The invoice Ledger to make payment towards
     * @param int    $amount  Amount to charge in fractional money units
     * @param array  $data    Additional data for the gateway, usually from request()
     *
     * @return Payment The resulting record of the authorized Payment
     */
    abstract public function authorize(User $user, Ledger $invoice, int $amount, array $data = []): Payment;

    /**
     * Initiates a gateway request for payment with the Merchant,
     * returning a response (usually a form or redirect).
     * Gateways that confirm internally may update the
     * Payment and return null to signify completion.
     *
     * @param Payment $payment The pre-authorized Payment from authorize()
     */
    abstract public function request(Payment $payment): ?ResponseInterface;
}

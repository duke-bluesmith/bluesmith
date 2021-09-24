<?php

namespace App\Merchants;

use App\BaseMerchant;
use App\Entities\Ledger;
use App\Entities\Payment;
use App\Entities\User;
use App\Models\PaymentModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

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
        'summary' => 'Use your internal currency credit.',
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
     * Fetches a User's balance.
     *
     * @param User $user The User to check
     *
     * @return int User balance in fractional money units
     */
    public function balance(User $user): int
    {
        return $user->balance;
    }

    /**
     * Performs pre-payment verification and starts the Payment record.
     *
     * @param User   $user    The User making the payment
     * @param Ledger $invoice The invoice Ledger to make payment towards
     * @param int    $amount  Amount to charge in fractional money units
     * @param array  $data    Additional data for the gateway, usually from request()
     *
     * @return Payment The resulting record of the authorized Payment
     */
    public function authorize(User $user, Ledger $invoice, int $amount, array $data = []): Payment
    {
        // Make sure User has enough balance
        if ($user->balance < $amount) {
            $code   = 413;
            $reason = lang('Payment.insufficient', [
                price_to_currency($user->balance),
                price_to_currency($amount),
            ]);
        } else {
            $code   = null;
            $reason = '';
        }

        return $this->createPayment($user, $invoice, $amount, $code, $reason = '');
    }

    /**
     * Initiates a gateway request for payment with the Merchant,
     * returning a response (usually a form or redirect).
     * Gateways that confirm internally may update the
     * Payment and return null to signify completion.
     *
     * @param Payment $payment The pre-authorized Payment from authorize()
     */
    public function request(Payment $payment): ?ResponseInterface
    {
        if (! $user = model(UserModel::class)->find($payment->user_id)) {
            throw new RuntimeException('Unable to locate User for Payment ' . $payment->id);
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

        return null;
    }
}

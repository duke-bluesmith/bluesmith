<?php

namespace App\Models;

use App\Entities\Transaction;
use App\Entities\User;
use RuntimeException;

class TransactionModel extends BaseModel
{
    protected $table          = 'transactions';
    protected $returnType     = Transaction::class;
    protected $useSoftDeletes = false;
    protected $updatedField   = '';
    protected $allowedFields  = [
        'user_id', 'credit', 'amount', 'summary',
    ];
    protected $validationRules = [
        'user_id' => 'required|is_natural_no_zero',
        'amount'  => 'required|is_natural_no_zero',
    ];

    /**
     * Credits a User, recording the Transaction.
     *
     * @param User   $user    The User to credit
     * @param int    $amount  The amount of credit
     * @param string $summary Optional description
     *
     * @throws RuntimeException
     */
    public function credit(User $user, int $amount, string $summary = ''): int
    {
        return $this->process($user, [
            'user_id' => $user->id,
            'credit'  => 1,
            'amount'  => $amount,
            'summary' => $summary,
        ]);
    }

    /**
     * Debits a User, recording the Transaction.
     *
     * @param User   $user    The User to debit
     * @param int    $amount  The amount of debit
     * @param string $summary Optional description
     *
     * @throws RuntimeException
     */
    public function debit(User $user, int $amount, string $summary = ''): int
    {
        return $this->process($user, [
            'user_id' => $user->id,
            'credit'  => 0,
            'amount'  => $amount,
            'summary' => $summary,
        ]);
    }

    /**
     * Creates the Transaction and updates the User's balance.
     *
     * @throws RuntimeException
     */
    protected function process(User $user, array $data): int
    {
        if (! $id = $this->insert($data)) {
            throw new RuntimeException(implode(' ', $this->errors()));
        }

        // Update the User's balance
        $balance = $data['credit']
            ? $user->balance + $data['amount']
            : $user->balance - $data['amount'];

        model(UserModel::class)->update($user->id, ['balance' => $balance]);

        return $id;
    }
}

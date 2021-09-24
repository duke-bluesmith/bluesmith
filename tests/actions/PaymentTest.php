<?php

namespace App\Actions;

use App\Models\ChargeModel;
use App\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ActionTrait;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class PaymentTest extends ProjectTestCase
{
    use ActionTrait;
    use AuthenticationTrait;
    use DatabaseTestTrait;

    protected $namespace = [
        'Tatter\Files',
        'Tatter\Outbox',
        'Tatter\Settings',
        'Tatter\Themes',
        'Tatter\Workflows',
        'Myth\Auth',
        'App',
    ];

    /**
     * UID of the Action to test
     *
     * @var string
     */
    protected $actionUid = 'payment';

    /**
     * Creates an invoice Ledger and adds a Charge
     */
    protected function setUp(): void
    {
        parent::setUp();

        $invoice = $this->job->getInvoice(true);

        model(ChargeModel::class)->insert([
            'ledger_id' => $invoice->id,
            'name'      => 'Test Charge',
            'amount'    => 1000,
            'quantity'  => 2,
        ]);
    }

    public function testGetReturnsForm()
    {
        $response = $this->expectResponse('get');

        $response->assertSee('Payments', 'h5');
    }

    public function testGetWithoutMerchants()
    {
        // Ensure the User has no balance, so is ineligible for Transactions
        $this->user->balance = 0;
        model(UserModel::class)->update($this->user->id, [
            'balance' => 0,
        ]);

        $response = $this->expectResponse('get');

        $response->assertSee('No eligible payment gateways', 'p');
    }

    public function testGetWithMerchants()
    {
        // Ensure the User has a balance, so is eligible for Transactions
        $this->user->balance = 10000;
        model(UserModel::class)->update($this->user->id, [
            'balance' => 10000,
        ]);

        $response = $this->expectResponse('get');

        $response->assertSee('Bluechips', 'label');
    }
}

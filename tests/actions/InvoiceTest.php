<?php

namespace App\Actions;

use App\Models\ChargeModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ActionTrait;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class InvoiceTest extends ProjectTestCase
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
    protected $actionId = 'invoice';

    public function testUpCreatesInvoice()
    {
        $this->expectNull('up');

        $this->seeInDatabase('ledgers', [
            'job_id'   => $this->job->id,
            'estimate' => 0,
        ]);
    }

    public function testUpCreatesCharges()
    {
        $estimate = $this->job->getEstimate(true);
        $charge   = fake(ChargeModel::class, [
            'ledger_id' => $estimate->id,
        ]);

        $this->expectNull('up');

        $this->seeInDatabase('charges', [
            'ledger_id' => $estimate->id,
            'amount'    => $charge->amount,
        ]);
    }

    public function testGetReturnsForm()
    {
        $response = $this->expectResponse('get');

        $response->assertSee(lang('Pub.clients'), 'h4');
        $response->assertSee('Charges', 'h4');
    }
}

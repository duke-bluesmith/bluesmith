<?php namespace App\Entities;

use App\Models\ChargeModel;
use App\Models\UserModel;
use Tatter\Settings\Models\SettingModel;
use Tests\Support\ActionTestCase;

class PaymentTest extends ActionTestCase
{
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
		$response = $this->get($this->route);

		$response->assertSee('Payments', 'h5');
	}

	public function testGetWithoutMerchants()
	{
		// Ensure the User has no balance, so is ineligible for Transactions
		$this->user->balance = 0;
		model(UserModel::class)->update($this->user->id, [
			'balance' => 0,
		]);

		$response = $this->get($this->route);

		$response->assertSee('No eligible payment gateways', 'p');
	}

	public function testGetWithMerchants()
	{
		// Ensure the User has a balance, so is eligible for Transactions
		$this->user->balance = 10000;
		model(UserModel::class)->update($this->user->id, [
			'balance' => 10000,
		]);

		$response = $this->get($this->route);

		$response->assertSee('Bluechips', 'label');
	}
}

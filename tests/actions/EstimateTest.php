<?php namespace App\Entities;

use App\Models\ChargeModel;
use Tatter\Settings\Models\SettingModel;
use Tests\Support\ActionTestCase;

class EstimateTest extends ActionTestCase
{
	/**
	 * UID of the Action to test
	 * 
	 * @var string
	 */
	protected $actionUid = 'estimate';

	/**
	 * Creates an estimate Ledger and adds a Charge
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$estimate = $this->job->getEstimate(true);

		model(ChargeModel::class)->insert([
			'ledger_id' => $estimate->id,
			'name'      => 'Test Charge',
			'amount'    => 1000,
			'quantity'  => 2,
		]);
	}

	public function testGetReturnsForm()
	{
		$response = $this->get($this->route);

		$response->assertSee('Charges', 'h3');
	}

	public function testPostSavesDescription()
	{
		$response = $this->post($this->route, [
			'users'       => [$this->user->id],
			'description' => 'foobar',
		]);
		$response->assertRedirect();

		$this->seeInDatabase('ledgers', ['description' => 'foobar']);
	}

	public function testPostNoUsers()
	{
		$response = $this->post($this->route, [
			'users'       => [],
			'description' => 'foobar',
		]);
		$response->assertRedirect();

		$response->assertSessionHas('error', lang('Actions.needClients'));
	}

	public function testPostSendsEmail()
	{
		$response = $this->post($this->route, [
			'users'       => [$this->user->id],
			'description' => 'foobar',
		]);
		$response->assertRedirect();

		$this->seeInDatabase('emails_jobs', ['job_id' => $this->job->id]);
	}
}

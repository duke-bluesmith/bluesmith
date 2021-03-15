<?php namespace App\Entities;

use App\Models\ChargeModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ActionTrait;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

class EstimateTest extends ProjectTestCase
{
	use ActionTrait, AuthenticationTrait, DatabaseTestTrait;

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
		$response = $this->expectResponse('get');

		$response->assertSee('Charges', 'h3');
	}

	public function testPost()
	{
		$_POST = [
			'users'       => [$this->user->id],
			'description' => 'foobar',
		];

		$response = $this->expectNull('post');

		// Verify the description was updated
		$this->seeInDatabase('ledgers', ['description' => 'foobar']);

		// Verify an email was sent
		$this->seeInDatabase('emails_jobs', ['job_id' => $this->job->id]);
	}

	public function testPostInvalidUsers()
	{
		$_POST = [
			'users'       => [42, 'jimmy'],
			'description' => 'foobar',
		];

		$response = $this->expectNull('post');

		// Verify the description was still updated
		$this->seeInDatabase('ledgers', ['description' => 'foobar']);

		// Make sure no emails were sent
		$this->dontSeeInDatabase('emails_jobs', ['job_id' => $this->job->id]);

		// Check for the alert
		$this->assertArrayHasKey('alerts-queue', $_SESSION);
		$this->assertEquals([
			'class' => 'warning',
			'text'  => 'Unable to locate user #42',
		], $_SESSION['alerts-queue'][0]);
	}
}

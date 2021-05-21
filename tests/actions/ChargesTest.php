<?php namespace App\Actions;

use App\Entities\Ledger;
use App\Models\ChargeModel;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ActionTrait;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

class ChargesTest extends ProjectTestCase
{
	use ActionTrait, AuthenticationTrait, DatabaseTestTrait;

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
	protected $actionUid = 'charges';

	public function testUpCreatesEstimate()
	{
		$this->expectNull('up');

		$this->seeInDatabase('ledgers', [
			'job_id'   => $this->job->id,
			'estimate' => 1,
		]);
	}

	public function testGetReturnsForm()
	{
		$response = $this->expectResponse('get');

		$response->assertSee('Add a Charge', 'h3');
	}
}

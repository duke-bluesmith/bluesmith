<?php

namespace App\Models;

use App\Entities\User;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class TransactionModelTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	// Initialize the database once
	protected $migrateOnce = true;
	protected $seedOnce    = true;

	/**
	 * @var User
	 */
	private $user;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = fake(UserModel::class);
	}

	public function testCreditCreatesTransaction()
	{
		$result = model(TransactionModel::class)->credit($this->user, 100, 'testCreditCreatesTransaction');

		$this->assertIsInt($result);
		$this->seeInDatabase('transactions', [
			'user_id' => $this->user->id,
			'amount'  => 100,
			'credit'  => 1,
			'summary' => 'testCreditCreatesTransaction',
		]);
	}

	public function testCreditIncreasesUserBalance()
	{
		$expected = $this->user->balance + 500;

		$result = model(TransactionModel::class)->credit($this->user, 500);
		$this->assertIsInt($result);

		$user = model(UserModel::class)->find($this->user->id);
		$this->assertSame($expected, $user->balance);
	}

	public function testDebitCreatesTransaction()
	{
		$result = model(TransactionModel::class)->debit($this->user, 200, 'testDebitCreatesTransaction');

		$this->assertIsInt($result);
		$this->seeInDatabase('transactions', [
			'user_id' => $this->user->id,
			'amount'  => 200,
			'credit'  => 0,
			'summary' => 'testDebitCreatesTransaction',
		]);
	}

	public function testDebitDecreasesUserBalance()
	{
		$expected = $this->user->balance - 700;

		$result = model(TransactionModel::class)->debit($this->user, 700);
		$this->assertIsInt($result);

		$user = model(UserModel::class)->find($this->user->id);
		$this->assertSame($expected, $user->balance);
	}

	public function testProcessThrowsOnInvalidInput()
	{
		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('The amount field must only contain digits and must be greater than zero');

		model(TransactionModel::class)->credit($this->user, -100);
	}
}

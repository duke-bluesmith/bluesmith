<?php namespace App\Models;

use App\Entities\User;
use Tests\Support\Fakers\UserFaker;
use Tests\Support\DatabaseTestCase;

class TransactionModelTest extends DatabaseTestCase
{
	/**
	 * @var User
	 */
	private $user;

	protected function setUp(): void
	{
		parent::setUp();

		$this->user = fake(UserFaker::class);
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
		$this->assertEquals($expected, $user->balance);
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
		$this->assertEquals($expected, $user->balance);
	}

	public function testProcessThrowsOnInvalidInput()
	{
		$this->expectException('RuntimeException');
		$this->expectExceptionMessage('');

		model(TransactionModel::class)->credit($this->user, -100);
	}
}

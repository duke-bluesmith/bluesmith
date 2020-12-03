<?php namespace App\Entities;

use CodeIgniter\Test\CIUnitTestCase;

class PaymentStatusTest extends CIUnitTestCase
{
	/**
	 * @param string $reason
	 * @param int $json
	 *
	 * @return PaymentStatus
	 */
	private function createPaymentStatus(string $reason, int $json): PaymentStatus
	{
		// Create a PaymentStatus
		return new PaymentStatus([
			'payment_id' => 1,
			'code'       => 0,
			'reason'     => $reason,
			'json'       => $json,
		]);
	}

	/**
	 * @dataProvider statusProvider
	 */
	public function testGetReason(string $reason, int $json, bool $raw, bool $array, $expected)
	{
		$status = $this->createPaymentStatus($reason, $json);
		$result = $status->getReason($raw, $array);

		$this->assertEquals($expected, $result);
	}

	public function statusProvider()
	{
		$string = '{"phrase":"test"}';
		$array  = ['phrase' => 'test'];
		$object = (object) $array;

		return [
			['test reason', 0, false, false, 'test reason'],
			['test reason', 0, false, true, 'test reason'],
			['test reason', 0, true, false, 'test reason'],
			['test reason', 0, true, true, 'test reason'],
			[$string, 1, false, false, $object],
			[$string, 1, false, true, $array],
			[$string, 1, true, false, $string],
			[$string, 1, true, true, $string],
		];
	}
}

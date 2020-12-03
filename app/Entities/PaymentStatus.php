<?php namespace App\Entities;

class PaymentStatus extends BaseEntity
{
	protected $table = 'payment_statuses';
	protected $casts = [
		'payment_id' => 'int',
		'code'       => 'int',
		'json'       => 'bool',
	];

	/**
	 * Decodes the reason if it was JSON
	 *
	 * @param bool $raw   Whether to decode JSON values
	 * @param bool $array Whether to decode JSON as an array
	 *
	 * @return string|object
	 */
	public function getReason(bool $raw = false, bool $array = false)
	{
		if ($this->attributes['json'] && ! $raw)
		{
			return $this->castAs($this->attributes['reason'], $array ? 'json-array' : 'json');
		}

		return $this->attributes['reason'];
	}
}

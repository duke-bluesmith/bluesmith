<?php namespace App\Entities;

class Material extends BaseEntity
{
	protected $table = 'materials';

	protected $casts = [
		'method_id' => 'int',
		'cost'      => '?int',
		'sortorder' => 'int',
	];
}

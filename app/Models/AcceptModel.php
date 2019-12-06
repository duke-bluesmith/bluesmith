<?php namespace App\Models;

class AcceptModel extends BaseModel
{
	protected $table           = 'accepts';
	protected $allowedFields   = ['job_id', 'user_id'];
	protected $useSoftDeletes  = false;

	protected $validationRules = [
		'job_id'  => 'required|integer',
		'user_id' => 'required|integer',
    ];
}

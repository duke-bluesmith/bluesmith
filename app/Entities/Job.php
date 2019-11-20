<?php namespace App\Entities;

class Job extends \Tatter\Workflows\Entities\Job
{
	use \Tatter\Relations\Traits\EntityTrait;

	protected $table      = 'jobs';
	protected $primaryKey = 'id';
}

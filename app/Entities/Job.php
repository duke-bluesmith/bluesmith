<?php namespace App\Entities;

use App\Models\OptionModel;

class Job extends \Tatter\Workflows\Entities\Job
{
	public function getOptions()
	{
		$options = new OptionModel();
		$return  = [];
		
		foreach ($options
			->select('options.*')
			->join('jobs_options', 'options.id = jobs_options.job_id')
			->where('jobs_options.job_id', $this->attributes['id'])
			->findAll() as $option)
		{
			$return[$option->id] = $option;
		}
		
		return $return;	
	}
}

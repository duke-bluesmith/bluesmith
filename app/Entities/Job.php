<?php namespace App\Entities;

class Job extends \Tatter\Workflows\Entities\Job
{
	// Writes out this job's options to the database
	public function updateOptions()
	{
		$builder = db_connect()->table('jobs_options');
		
		// Determine which options are set
		$optionIds = isset($this->attributes['options']) ? array_keys($this->attributes['options']) : [];
		
		// Clear existing options
		$builder->where('job_id', $this->attributes['id'])->delete();
		
		// Add in any toggled options
		foreach ($optionIds as $optionId)
		{
			$row = [
				'job_id'    => $this->attributes['id'],
				'option_id' => $optionId,
			]
			
			$builder->insert($row);
		}
	}
}

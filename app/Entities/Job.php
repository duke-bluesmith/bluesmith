<?php namespace App\Entities;

class Job extends \Tatter\Workflows\Entities\Job
{
	// Set options for a job in the database
	public function setOptions($optionIds)
	{
		$builder = db_connect()->table('jobs_options');
		
		// Determine which options are set
		$optionIds = isset($this->attributes['options']) ? array_keys($this->attributes['options']) : [];
		
		// Clear existing options
		$builder->where('job_id', $this->attributes['id'])->delete();
		
		// If there are no options then finish
		if (empty($optionIds))
		{
			return;
		}
		
		// Add back any selected options
		$rows = [];
		foreach ($optionIds as $optionId)
		{
			$rows[] = [
				'job_id'    => $this->attributes['id'],
				'option_id' => $optionId,
			];
		}

		$builder->insertBatch($rows);
	}
}

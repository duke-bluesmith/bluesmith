<?php namespace App\Entities;

class Job extends \Tatter\Workflows\Entities\Job
{
	// Check if this job has the requested option
	public function hasOption($optionId)
	{
		// Check if options are already loaded
		if (isset($this->attributes['options']))
		{
			foreach ($this->attributes['options'] as $option)
			{
				if ($option->id == $optionId)
				{
					return true;
				}
			}
			
			return false;
		}
		
		// Check the database
		$builder = db_connect()->table('jobs_options');
		
		return (bool)$builder
			->where('job_id', $this->attributes['id'])
			->where('option_id', $optionId)
			->countAllResults();
	}

	// Set options for a job in the database
	public function updateOptions($optionIds)
	{
		$builder = db_connect()->table('jobs_options');
		
		// Clear existing options
		$builder->where('job_id', $this->attributes['id'])->delete();
		unset($this->attributes['options']);

		// If there are no IDs then finish
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

	// Check if this job has the requested file
	public function hasFile($fileId)
	{
		// Check if files are already loaded
		if (isset($this->attributes['files']))
		{
			foreach ($this->attributes['files'] as $file)
			{
				if ($file->id == $fileId)
				{
					return true;
				}
			}
			
			return false;
		}
		
		// Check the database
		$builder = db_connect()->table('files_jobs');
		
		return (bool)$builder
			->where('file_id', $fileId)
			->where('job_id', $this->attributes['id'])
			->countAllResults();
	}

	// Set files for a job in the database
	public function updateFiles($fileIds)
	{
		$builder = db_connect()->table('files_jobs');
		
		// Clear existing files
		$builder->where('job_id', $this->attributes['id'])->delete();
		unset($this->attributes['files']);

		// If there are no IDs then finish
		if (empty($fileIds))
		{
			return;
		}
		
		// Add back any selected files
		$rows = [];
		foreach ($fileIds as $fileId)
		{
			$rows[] = [
				'file_id' => $fileId,
				'job_id'  => $this->attributes['id'],
			];
		}

		$builder->insertBatch($rows);
	}
}

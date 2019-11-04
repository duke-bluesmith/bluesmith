<?php namespace App\Models;

use Tatter\Permits\Traits\PermitsTrait;

class JobModel extends \Tatter\Relations\Model
{
	// Traits
	use PermitsTrait;

	protected $table      = 'jobs';
	protected $primaryKey = 'id';
	
	protected $with = ['options'];

	protected $returnType = 'App\Entities\Job';
	protected $useSoftDeletes = true;

	protected $allowedFields = [
		'name', 'summary', 'workflow_id', 'stage_id', 'material_id'
	];

	protected $useTimestamps = true;

	protected $validationRules    = [
		'name' => 'required|max_length[255]',
	];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	
	protected $afterInsert  = ['logInsert'];
	protected $beforeUpdate = ['logUpdate'];

	// Permits
	/* Default mode:
	 * 4 Domain list, no create
	 * 6 Owner  read, write
	 * 6 Group  read, write
	 * 4 World  read, no write
	 */	
	protected $mode = 06660;
	
	// Name of the user ID in this model's objects
	protected $userKey;
	
	// Table that joins this model's objects to its users
	protected $usersPivot;
	
	// Name of the group ID in this model's objects
	protected $groupKey;
	
	// Table that joins this model's objects to its groups
	protected $groupsPivot;
	
	// Name of this object's ID in the pivot tables
	protected $pivotKey;
	
	// Log successful insertions
	protected function logInsert(array $data)
	{
		if (! $data['result'])
		{
			return false;
		}
		
		// determine user source from config
		$userId = session(config('Workflows')->userSource);
		
		// build the row
		$row = [
			'job_id'     => $data['result']->connID->insert_id,
			'stage_to'   => $data['data']['stage_id'],
			'created_by' => $userId,
			'created_at' => date('Y-m-d H:i:s'),
		];
		
		// add it to the database
		$db = db_connect();
		$db->table('joblogs')->insert($row);
		
		return $data;
	}
	
	// Log updates that result in a stage change
	protected function logUpdate(array $data)
	{
		$db = db_connect();

		// determine user source from config
		$userId = session(config('Workflows')->userSource);
		
		// process each updated entry
		foreach ($data['id'] as $id)
		{
			// get the job to be updated
			$job = $this->find($id);
			if (empty($job))
			{
				continue;
			}

			// ignore instances where the stage won't change
			if (! in_array('stage_id', array_keys($data['data'])))
			{
				continue;
			}
			
			if ($data['data']['stage_id'] == $job->stage_id)
			{
				continue;
			}

			// build the row
			$row = [
				'job_id'     => $job->id,
				'stage_from' => $data['data']['stage_id'],
				'stage_to'   => $job->stage_id,
				'created_by' => $userId,
				'created_at' => date('Y-m-d H:i:s'),
			];
		
			// add it to the database
			$db->table('joblogs')->insert($row);
		}
		
		return $data;
	}
}


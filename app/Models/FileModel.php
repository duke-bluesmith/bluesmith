<?php namespace App\Models;

class FileModel extends BaseModel
{
	protected $table      = 'files';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = true;

	protected $allowedFields = ['name', 'filename', 'clientname', 'type', 'size'];

	protected $useTimestamps = true;

	protected $validationRules    = [
		'name'     => 'required|max_length[255]',
	];
	protected $validationMessages = [];
	protected $skipValidation     = false;
	
	// Permits
	protected $tableMode  = 0662;
	protected $rowMode    = 0660;
	
	// table that joins this model's objects to its users
	protected $usersPivot = 'files_users';
	
	// name of this object's ID in the pivot tables
	protected $pivotKey = 'file_id';

	// Returns an array of all a user's files
    public function getForUser(int $userId): array
    {
        return $this->builder()
			->select('files.*')
			->join('files_users', 'files_users.file_id = files.id', 'left')
			->where('user_id', $userId)
			->get()->getResult();
    }
	
	// Associate a file with a user    
	public function addToUser(int $fileId, int $userId)
	{
		$row = [
			'file_id'  => (int)$fileId,
			'user_id'  => (int)$userId,
		];
		
		return $this->db->table('files_users')->insert($row);
	}
}

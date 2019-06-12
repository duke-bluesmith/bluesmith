<?php namespace App\Models;

use Tatter\Permits\Models\PModel;

class BaseModel extends PModel
{
	// Audits
	use \Tatter\Audits\Traits\AuditsTrait;
	protected $afterInsert = ['auditInsert'];
	protected $afterUpdate = ['auditUpdate'];
	protected $afterDelete = ['auditDelete'];

	// Permits
	protected $tableMode  = 0664;
	protected $rowMode    = 0664;
	
	// name of the user ID in this model's objects
	protected $userKey;
	// table that joins this model's objects to its users
	protected $usersPivot;
	
	// name of the group ID in this model's objects
	protected $groupKey;
	// table that joins this model's objects to its groups
	protected $groupsPivot;
	
	// name of this object's ID in the pivot tables
	protected $pivotKey;
}

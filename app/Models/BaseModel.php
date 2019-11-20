<?php namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
	// Traits
	use \Tatter\Audits\Traits\AuditsTrait;
	use \Tatter\Permits\Traits\PermitsTrait;
	use \Tatter\Relations\Traits\ModelTrait;

	// Audits
	protected $afterInsert = ['auditInsert'];
	protected $afterUpdate = ['auditUpdate'];
	protected $afterDelete = ['auditDelete'];

	// Permits
	/* Default mode:
	 * 4 Domain list, no create
	 * 6 Owner  read, write
	 * 6 Group  read, write
	 * 4 World  read, no write
	 */	
	protected $mode = 04664;
	
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

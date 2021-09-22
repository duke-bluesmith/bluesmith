<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    // Traits
    use \Tatter\Audits\Traits\AuditsTrait;
    use \Tatter\Permits\Traits\PermitsTrait;
    use \Tatter\Relations\Traits\ModelTrait;

    // Core defaults
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $skipValidation = false;

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

    // Properties that need to be filled in by each model to use Permits
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
}

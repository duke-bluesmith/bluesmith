<?php

namespace App\Models;

use CodeIgniter\Model;
use Tatter\Audits\Traits\AuditsTrait;
use Tatter\Permits\Traits\PermitsTrait;
use Tatter\Relations\Traits\ModelTrait;

class BaseModel extends Model
{
    // Traits
    use AuditsTrait;
    use PermitsTrait;
    use ModelTrait;

    // Core defaults
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $skipValidation = false;

    // Audits
    protected $afterInsert = ['auditInsert'];
    protected $afterDelete = ['auditDelete'];
    protected $afterUpdate = ['auditUpdate'];
}

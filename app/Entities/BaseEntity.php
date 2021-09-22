<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class BaseEntity extends Entity
{
    use \Tatter\Relations\Traits\EntityTrait;

    protected $primaryKey = 'id';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}

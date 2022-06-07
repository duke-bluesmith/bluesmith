<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use Tatter\Relations\Traits\EntityTrait;

class BaseEntity extends Entity
{
    use EntityTrait;

    protected $primaryKey = 'id';
    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];
}

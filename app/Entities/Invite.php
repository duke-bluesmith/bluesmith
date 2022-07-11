<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Invite extends Entity
{
    protected $dates = ['created_at', 'expired_at'];
    protected $casts = [
        'job_id' => 'int',
        'token'  => 'string',
    ];
}

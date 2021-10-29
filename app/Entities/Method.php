<?php

namespace App\Entities;

class Method extends BaseEntity
{
    protected $table = 'methods';
    protected $casts = [
        'sortorder' => 'int',
    ];
}

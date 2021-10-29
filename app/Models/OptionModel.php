<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table           = 'options';
    protected $primaryKey      = 'id';
    protected $returnType      = 'object';
    protected $useSoftDeletes  = true;
    protected $allowedFields   = ['name', 'summary', 'description'];
    protected $useTimestamps   = true;
    protected $validationRules = [
        'name' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}

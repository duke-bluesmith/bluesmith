<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table          = 'options';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;
    protected $skipValidation = false;
    protected $allowedFields  = [
        'name',
        'summary',
        'description',
    ];
    protected $validationRules = [
        'name'        => 'required|string|max_length[127]',
        'summary'     => 'required|string|max_length[127]',
        'description' => 'permit_empty|string|max_length[255]',
    ];
}

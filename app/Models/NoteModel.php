<?php

namespace App\Models;

use App\Entities\Note;
use CodeIgniter\Model;

class NoteModel extends Model
{
    use \Tatter\Relations\Traits\ModelTrait;

    protected $primaryKey     = 'id';
    protected $table          = 'notes';
    protected $returnType     = Note::class;
    protected $useTimestamps  = true;
    protected $useSoftDeletes = true;
    protected $skipValidation = false;
    protected $allowedFields  = [
        'job_id',
        'user_id',
        'content',
    ];
    protected $validationRules = [
        'job_id'  => 'required|integer',
        'user_id' => 'required|integer',
    ];
}

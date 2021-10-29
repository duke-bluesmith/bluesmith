<?php

namespace App\Models;

class InviteModel extends BaseModel
{
    protected $table           = 'invites';
    protected $allowedFields   = ['email', 'token', 'job_id', 'created_at', 'expired_at'];
    protected $useTimestamps   = false;
    protected $useSoftDeletes  = false;
    protected $validationRules = [
        'job_id' => 'required|integer',
        'email'  => 'required|valid_email',
        'token'  => 'required|hex',
    ];
}

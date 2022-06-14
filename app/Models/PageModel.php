<?php

namespace App\Models;

/**
 * @psalm-suppress MethodSignatureMismatch
 */
class PageModel extends BaseModel
{
    protected $table           = 'pages';
    protected $allowedFields   = ['name', 'content'];
    protected $validationRules = [
        'name' => 'required',
    ];
}

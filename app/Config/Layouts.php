<?php

namespace Config;

use Tatter\Layouts\Config\Layouts as BaseConfig;

class Layouts extends BaseConfig
{
    public string $default = 'layouts/public';
    public string $manage  = 'layouts/manage';
    public string $outbox  = 'layouts/manage';
}

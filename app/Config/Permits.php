<?php

namespace Config;

class Permits extends \Tatter\Permits\Config\Permits
{
    /**
     * @var array<string,mixed>
     */
    public array $jobs = [
        'admin'      => self::NOBODY,
        'create'     => self::USERS,
        'list'       => self::NOBODY,
        'read'       => self::OWNERS,
        'update'     => self::OWNERS,
        'delete'     => self::OWNERS,
        'userKey'    => null,
        'pivotKey'   => 'job_id',
        'pivotTable' => 'jobs_users',
    ];
}

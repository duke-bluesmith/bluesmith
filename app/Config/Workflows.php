<?php

namespace Config;

use App\Models\JobModel;
use Tatter\Workflows\Config\Workflows as BaseConfig;

class Workflows extends BaseConfig
{
    /**
     * The model to use for jobs.
     *
     * @var class-string<JobModel>
     */
    public string $jobModel = JobModel::class;

    /**
     * Views to display for various function.
     *
     * @var array<string,string>
     */
    public array $views = [
        'job'      => 'account/job',
        'messages' => 'Tatter\Workflows\Views\messages',
        'complete' => 'Tatter\Workflows\Views\complete',
        'deleted'  => 'Tatter\Workflows\Views\deleted',
        'filter'   => 'Tatter\Workflows\Views\filter',
        'workflow' => 'Tatter\Workflows\Views\workflow',
        'info'     => 'actions/info',
    ];
}

<?php

namespace Config;

use App\Models\JobModel;

class Workflows extends \Tatter\Workflows\Config\Workflows
{
    // The model to use for jobs
    public string $jobModel = JobModel::class;

    // Views to display for each function
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

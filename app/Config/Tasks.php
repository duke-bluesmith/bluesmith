<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Tasks\Scheduler;

class Tasks extends BaseConfig
{
    /**
     * Register any tasks within this method for the application.
     */
    public function init(Scheduler $schedule)
    {
        $schedule->command('email:messages')->hourly();
        $schedule->command('email:reminder')->days([1, 3, 5])->hours([10]); // Mon-Wed-Fri at 10am
    }
}

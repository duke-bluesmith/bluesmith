<?php

namespace App;

use App\Actions\RenderTrait;
use App\Entities\Job;
use Tatter\Workflows\BaseAction as ModuleBaseAction;

/**
 * Base Action Class
 *
 * Provides common support methods for all app Actions,
 * and updated property types for static analysis.
 *
 * @property Job $job
 */
abstract class BaseAction extends ModuleBaseAction
{
    use RenderTrait;

    protected $helpers = ['currency', 'form', 'inflector', 'number'];
}

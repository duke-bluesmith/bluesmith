<?php

namespace App;

use App\Entities\Job;
use App\Models\JobModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Workflows;
use Tatter\Workflows\BaseAction as ModuleBaseAction;

/**
 * BaseAction Abstract Class
 *
 * Provides common support methods for all
 * app Actions, and updated property types
 * for static analysis.
 */
abstract class BaseAction extends ModuleBaseAction
{
    /**
     * @var Workflows
     */
    public $config;

    /**
     * @var Job
     */
    public $job;

    /**
     * @var JobModel
     */
    public $jobs;

    /**
     * Loads frequently-needed helpers
     */
    public function initialize()
    {
        helper(['currency', 'form', 'inflector', 'number']);
    }

    /**
     * Renders the content within the Action layout.
     *
     * @param string $view The view file
     * @param array  $data Any variable data to pass to View
     */
    public function render(string $view, array $data = []): ResponseInterface
    {
        // Add layout data
        $data['action'] = $this;
        $data['job']    = $this->job;
        $data['header'] = $this->attributes['header'];

        // If this is the last stage for a user then "submit"
        if (null === $next = $this->job->next()) {
            $data['buttonText'] = 'Complete';
        } elseif ($this->attributes['role'] !== $next->action->role) {
            $data['buttonText'] = 'Submit';
        } else {
            $data['buttonText'] = 'Continue';
        }

        return $this->response->setBody(view($view, $data));
    }
}

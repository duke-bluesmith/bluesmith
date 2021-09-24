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
        $data['job'] = $this->job;

        // Add layout data
        $data['header']     = $this->attributes['header'];
        $data['actionMenu'] = view('actions/layout/menu', ['action' => $this]);

        return $this->response->setBody(view($view, $data));
    }
}

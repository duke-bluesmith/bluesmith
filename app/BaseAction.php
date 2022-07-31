<?php

namespace App;

use App\Entities\Job;
use CodeIgniter\HTTP\ResponseInterface;
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
    protected $helpers = ['currency', 'form', 'inflector', 'number'];

    /**
     * Renders the content within the Action layout.
     *
     * @param string $view The view file
     * @param array  $data Any variable data to pass to View
     */
    protected function render(string $view, array $data = []): ResponseInterface
    {
        $attributes = static::getAttributes();

        // Determine the text for the button based on the next stage
        $next = $this->job->getStage()->getNext();
        if ($next === null) {
            $buttonText = 'Complete';
        // If this is the last stage for a user then "submit"
        } elseif ($attributes['role'] !== $next->getAction()::getAttributes()['role']) {
            $buttonText = 'Submit';
        } else {
            $buttonText = 'Continue';
        }

        // Add layout data
        $data = array_merge([
            'action'     => $this,
            'header'     => $attributes['header'],
            'buttonText' => $buttonText,
        ], $data);

        return parent::render($view, $data);
    }
}

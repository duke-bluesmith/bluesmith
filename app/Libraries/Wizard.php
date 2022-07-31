<?php

namespace App\Libraries;

use App\Entities\Job;
use App\Entities\Step;
use DomainException;

/**
 * Wizard Class
 *
 * Centralized library to build the stage-specific
 * step wizard.
 */
final class Wizard
{
    /**
     * @var Step[]
     */
    private array $steps;

    /**
     * Generates a new Wizard from the given Job.
     */
    public static function fromJob(Job $job): self
    {
        $steps    = [];
        $step     = null;
        $position = -1;
        $managed  = (bool) $job->stage->action->role;
        $previous = $job->getStage()->getPrevious();
        $next     = $job->getStage()->getNext();
        $nextUrl  = null;

        foreach ($job->getWorkflow()->getStages() as $stage) {
            $attributes = $stage->getAction()::getAttributes();

            // Check for an early completion
            if (! $managed && $position === 1 && $attributes['role'] !== '') {
                break;
            }

            $data = [
                'icon'    => $attributes['icon'],
                'summary' => $attributes['summary'],
            ];

            // Check for the current stage
            if ($stage->id === $job->stage->id) {
                $data['color'] = 'success';

                $position = 0;
                if ($previous !== null) {
                    // Set the URL on the most recent Step
                    $step->previousUrl = site_url($previous->getRoute() . $job->id);
                }
            }
            // Previous stage
            elseif ($position === -1) {
                // Previous staff stages are orange
                $data['color'] = $attributes['role'] === ''
                    ? 'primary'
                    : 'warning';
            }
            // Upcoming stage
            else {
                $data['color'] = 'secondary';
            }
            $data['position'] = $position;

            if ($nextUrl !== null) {
                $data['nextUrl'] = $nextUrl;
                $nextUrl         = null;
            }

            $step    = new Step($data);
            $steps[] = $step;

            if ($position === 0) {
                $position = 1;
                $nextUrl  = $next ? site_url($next->getRoute() . $job->id) : '';
            }
        }

        return new self($steps);
    }

    /**
     * Formats the Wizard with each Step for the Action header.
     *
     * @param Step[] $steps
     *
     * @throws DomainException For empty input
     */
    private function __construct(array $steps)
    {
        if (count($steps) < 1) {
            throw new DomainException('You must supply at least one step.');
        }

        $this->steps = $steps;
    }

    /**
     * Formats the Wizard with each Step for the Action header.
     */
    public function __toString(): string
    {
        $output = PHP_EOL;

        $output .= '<div class="d-flex justify-content-between py-3">' . PHP_EOL;
        $output .= implode(PHP_EOL, $this->steps);

        return $output . '</div>' . PHP_EOL;
    }
}

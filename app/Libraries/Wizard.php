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
        $previous = $job->previous();
        $next     = $job->next();
        $nextUrl  = null;

        foreach ($job->stages as $stage) {
            // Check for an early completion
            if (! $managed && $position === 1 && $stage->action->role !== '') {
                break;
            }

            $data = [
                'icon'    => $stage->action->icon,
                'summary' => $stage->action->summary,
            ];

            // Check for the current stage
            if ($stage->id === $job->stage->id) {
                $data['color'] = 'success';

                $position = 0;
                if ($previous !== null) {
                    // Set the URL on the most recent Step
                    $step->previousUrl = site_url($previous->action->getRoute($job->id));
                }
            }
            // Previous stage
            elseif ($position === -1) {
                // Previous staff stages are orange
                $data['color'] = $stage->action->role === ''
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
                $nextUrl  = $next ? site_url($next->action->getRoute($job->id)) : '';
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

        return $output . ('</div>' . PHP_EOL);
    }
}

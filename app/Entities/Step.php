<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

/**
 * Representation of a single step in the step wizard.
 *
 * @see \App\Libraries\Wizard
 */
class Step extends Entity
{
    protected $casts = [
        'icon'        => 'string',
        'color'       => 'string',
        'summary'     => 'string',
        'position'    => 'int', // -1, 0, 1; past, current, future
        'previousUrl' => '?uri',
        'nextUrl'     => '?uri',
    ];

    /**
     * Formats the Step for display in the Action header.
     */
    public function __toString(): string
    {
        $lines  = [];
        $linked = false;

        // Determine the classes for the wrapping div
        $classes = [
            'rounded-circle',
            'text-center',
            'text-white',
            'p-2',
            'mr-1',
            'h4',
            'bg-' . $this->color,
        ];

        // Wrapping DIV
        $lines[] = '<div class="wizard-stage">';

        // Conditional link
        if ($this->previousUrl !== null) {
            $linked  = true;
            $lines[] = '<a href="' . $this->previousUrl . '" onclick="return confirm(\'Are you sure you want to regress this job?\');">';
        } elseif ($this->nextUrl !== null) {
            $linked  = true;
            $lines[] = '<a href="' . $this->nextUrl . '" onclick="return confirm(\'Are you sure you want to skip this stage?\');">';
        }

        // Circle
        $lines[] = '<div';
        $lines[] = "\t" . 'class="' . implode(' ', $classes) . '"';
        $lines[] = "\t" . 'style="width: 45px; height: 45px;"';
        $lines[] = "\t" . 'data-toggle="tooltip"';
        $lines[] = "\t" . 'title="' . $this->summary . '"';
        $lines[] = '>';

        // FontAwesome icon
        $lines[] = '<i class="' . $this->icon . '"></i>';

        // Close the circle
        $lines[] = '</div>';

        // Closing link
        if ($linked) {
            $lines[] = '</a>';
        }

        // Closing tag
        $lines[] = '</div>';

        return implode(PHP_EOL, $lines);
    }
}

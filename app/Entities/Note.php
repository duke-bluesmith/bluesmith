<?php

namespace App\Entities;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class Note extends BaseEntity
{
    protected $table = 'notes';
    protected $casts = [
        'job_id'  => 'int',
        'user_id' => 'int',
    ];

    /**
     * Initial default values
     */
    protected $attributes = [
        'content' => '',
    ];

    /**
     * Returns the content, optionally formatted from Markdown.
     *
     * @param bool $formatted Whether to format the result for display
     */
    public function getContent(bool $formatted = false): string
    {
        if (! $formatted || empty(trim($this->attributes['content']))) {
            return $this->attributes['content'];
        }

        return (new GithubFlavoredMarkdownConverter([
            'html_input'         => 'strip',
            'allow_unsafe_links' => false,
        ]))->convertToHtml($this->attributes['content']);
    }
}

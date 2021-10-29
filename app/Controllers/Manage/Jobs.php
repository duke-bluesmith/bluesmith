<?php

namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\JobModel;
use Closure;
use CodeIgniter\Exceptions\PageNotFoundException;
use Tatter\Workflows\Models\JoblogModel;

class Jobs extends BaseController
{
    /**
     * @var JobModel
     */
    protected $model;

    /**
     * Load the JobModel
     */
    public function __construct()
    {
        $this->model = model(JobModel::class); // @phpstan-ignore-line
    }

    /**
     * Displays a single Job with management options.
     *
     * @param int|string|null $jobId
     */
    public function show($jobId = null): string
    {
        if (null === $jobId || ! $job = $this->model->withDeleted()->find($jobId)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('jobs/show', [
            'title' => 'Job Details',
            'job'   => $job,
            'logs'  => model(JoblogModel::class)->findWithStages($job->id),
        ]);
    }

    /**
     * Displays the active compiled rows
     */
    public function active(): string
    {
        $filter = static function ($row) {
            return null === $row['deleted_at'] && null !== $row['stage_id'];
        };

        return $this->index('Active Jobs', $filter, 'created_at', false);
    }

    /**
     * Displays compiled rows for archived jobs
     */
    public function archive(): string
    {
        $filter = static function ($row) {
            return null === $row['deleted_at'] && null === $row['stage_id'];
        };

        return $this->index('Archived Jobs', $filter, 'updated_at', false);
    }

    /**
     * Displays all compiled rows (not deleted)
     */
    public function all(): string
    {
        $filter = static function ($row) {
            return null === $row['deleted_at'];
        };

        return $this->index('All Jobs', $filter, 'updated_at', false);
    }

    /**
     * Displays the compiled rows for deleted jobs
     */
    public function trash(): string
    {
        $filter = static function ($row) {
            return null !== $row['deleted_at'];
        };

        return $this->index('Deleted Jobs', $filter, 'deleted_at', false);
    }

    /**
     * Displays the compiled rows.
     */
    public function index(string $title = 'Jobs', ?Closure $filter = null, string $sort = 'stage_id', bool $ascending = true): string
    {
        return view('jobs/index', [
            'title' => $title,
            'rows'  => $this->model->getCompiledRows($filter, $sort, $ascending),
        ]);
    }
}

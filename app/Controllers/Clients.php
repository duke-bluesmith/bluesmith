<?php

namespace App\Controllers;

use App\Actions\AssignAction;
use App\Entities\Job;
use App\Entities\User;
use App\Models\JobModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Clients extends BaseController
{
    /**
     * Adds a new client to a job using the AssignAction methods.
     *
     * @param mixed|null $jobId
     */
    public function add($jobId = null): RedirectResponse
    {
        $job    = $this->getJob($jobId);
        $action = new AssignAction($job);
        $owners = array_column($job->users, 'id');

        /** @var User $user */
        $user = user();
        if (in_array($user->id, $owners, true) || $user->hasPermission('manageJobs')) {
            return $action->put();
        }

        return redirect()->back()->with('error', lang('Auth.notEnoughPrivilege'));
    }

    /**
     * Returns the Job matching the input parameter.
     *
     * @param int|string|null $jobId
     *
     * @throws PageNotFoundException
     */
    private function getJob($jobId): Job
    {
        if ($jobId === null || ! $job = model(JobModel::class)->find($jobId)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $job;
    }
}

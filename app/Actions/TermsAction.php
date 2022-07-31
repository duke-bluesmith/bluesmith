<?php

namespace App\Actions;

use App\BaseAction;
use App\Libraries\Mailer;
use App\Models\PageModel;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Job;

class TermsAction extends BaseAction
{
    public const HANDLER_ID = 'terms';
    public const ATTRIBUTES = [
        'name'     => 'Terms',
        'role'     => '',
        'icon'     => 'fas fa-file-contract',
        'category' => 'Define',
        'summary'  => 'Client accepts terms of service',
        'header'   => 'Terms of Service',
        'button'   => 'Accept the Terms',
    ];

    /**
     * Runs on a Job when it regresses through the workflow.
     */
    public static function down(Job $job): Job
    {
        // Remove acceptance
        $job->clearFlag('Accepted');

        return $job;
    }

    public function get(): ResponseInterface
    {
        return $this->render('actions/terms', [
            'job'  => $this->job,
            'page' => model(PageModel::class)->where('name', 'Terms')->first(),
        ]);
    }

    public function post(): ?ResponseInterface
    {
        $data = service('request')->getPost();

        if (empty($data['complete'])) {
            alert('warning', lang('Actions.mustAccept'));

            return redirect()->back();
        }

        $this->job->setFlag('Accepted');

        // Check if we need to send welcome email
        if ($this->job->getFlag('Welcomed') === null) {
            // Get client email addresses
            $recipients = [];

            foreach ($this->job->users as $user) {
                $recipients[] = $user->email;
            }

            if ($recipients) {
                // Send the email
                Mailer::forNewJob($recipients, $this->job);
                $this->job->setFlag('Welcomed');
            }
        }

        // End the action
        return null;
    }
}

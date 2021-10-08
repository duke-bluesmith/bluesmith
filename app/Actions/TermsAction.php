<?php

namespace App\Actions;

use App\BaseAction;
use App\Libraries\Mailer;
use App\Models\PageModel;
use CodeIgniter\HTTP\ResponseInterface;

class TermsAction extends BaseAction
{
    /**
     * @var array<string, string>
     */
    public $attributes = [
        'category' => 'Define',
        'name'     => 'Terms',
        'uid'      => 'terms',
        'role'     => '',
        'icon'     => 'fas fa-file-contract',
        'summary'  => 'Client accepts terms of service',
        'header'   => 'Terms of Service',
        'button'   => 'Accept the Terms',
    ];

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

    /**
     * Runs when job regresses back through the workflow.
     *
     * @return mixed
     */
    public function down()
    {
        // Remove acceptance
        $this->job->clearFlag('Accepted');

        return true;
    }
}

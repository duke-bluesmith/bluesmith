<?php

namespace App\Actions;

use App\BaseAction;
use App\Libraries\Mailer;
use App\Models\LedgerModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class EstimateAction extends BaseAction
{
    public const HANDLER_ID = 'estimate';
    public const ATTRIBUTES = [
        'name'     => 'Estimate',
        'role'     => 'manageJobs',
        'icon'     => 'fas fa-balance-scale-right',
        'category' => 'Assess',
        'summary'  => 'Staff issues estimate',
        'header'   => 'Issue Estimate',
        'button'   => 'Email Estimate',
    ];

    /**
     * Displays the Charges and form for sending
     * the estimate Ledger.
     */
    public function get(): ResponseInterface
    {
        return $this->render('actions/estimate', [
            'estimate' => $this->job->getEstimate(),
        ]);
    }

    /**
     * Processes form data and sends the Estimate
     * Email to each selected user.
     *
     * @return RedirectResponse|null
     */
    public function post(): ?ResponseInterface
    {
        // Update the description and reload the estimate Ledger
        model(LedgerModel::class)->update($this->job->estimate->id, [
            'description' => service('request')->getPost('description'),
        ]);

        $ledger = model(LedgerModel::class)->find($this->job->estimate->id);

        // Verify each user and grab their email address
        $recipients = [];

        foreach (service('request')->getPost('users') ?? [] as $userId) {
            if (! is_numeric($userId)) {
                continue;
            }

            if ($user = model(UserModel::class)->find($userId)) {
                $recipients[] = $user->email;
            } else {
                alert('warning', 'Unable to locate user #' . $userId);
            }
        }

        if ($recipients) {
            // Send the email
            Mailer::forEstimate($recipients, $this->job, $ledger);
        }

        // End the action
        return null;
    }
}

<?php

namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\ResponseInterface;

class ApproveAction extends BaseAction
{
    public const HANDLER_ID = 'approve';
    public const ATTRIBUTES = [
        'name'     => 'Approve',
        'role'     => '',
        'icon'     => 'fas fa-thumbs-up',
        'category' => 'Assess',
        'summary'  => 'Client approves the estimate',
        'header'   => 'Approval',
        'button'   => 'Approve Estimate',
    ];

    /**
     * Displays the Charges and form for
     * accepting the estimate Ledger.
     */
    public function get(): ResponseInterface
    {
        helper(['chat']);

        return $this->render('actions/approve', [
            'estimate' => $this->job->getEstimate(),
        ]);
    }

    /**
     * Processes the acceptance.
     *
     * @return null
     */
    public function post(): ?ResponseInterface
    {
        // End the action
        return null;
    }
}

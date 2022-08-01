<?php

namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Action;

class DeliverAction extends BaseAction
{
    public const HANDLER_ID = 'deliver';
    public const ATTRIBUTES = [
        'name'     => 'Deliver',
        'role'     => 'manageJobs',
        'icon'     => 'fas fa-truck',
        'category' => 'Complete',
        'summary'  => 'Staff delivers objects to client',
        'header'   => 'Delivery',
        'button'   => 'Delivery Complete',
    ];

    /**
     * Displays the delivery form.
     */
    public function get(): ResponseInterface
    {
        return $this->render('actions/deliver');
    }

    /**
     * Marks the items as delivered.
     *
     * @return null
     */
    public function post(): ?ResponseInterface
    {
        // End the action
        return null;
    }
}

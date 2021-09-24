<?php

namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Action;

class DeliverAction extends BaseAction
{
    /**
     * @var array<string, string>
     */
    public $attributes = [
        'category' => 'Complete',
        'name'     => 'Deliver',
        'uid'      => 'deliver',
        'role'     => 'manageJobs',
        'icon'     => 'fas fa-truck',
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

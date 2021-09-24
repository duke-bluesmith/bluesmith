<?php

namespace App\Entities;

use Tatter\Relations\Traits\EntityTrait;
use Tatter\Users\Entities\MythEntity;
use Tatter\Workflows\Entities\Workflow;
use Tatter\Workflows\Models\WorkflowModel;

class User extends MythEntity
{
    use EntityTrait;

    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $casts      = [
        'active'           => 'boolean',
        'force_pass_reset' => 'boolean',
        'balance'          => 'int',
    ];

    /**
     * @var Workflow[]|null
     */
    private $workflows;

    /**
     * Returns a full name: "First Last"
     */
    public function getName(): string
    {
        return trim(trim($this->firstname) . ' ' . trim($this->lastname));
    }

    /**
     * Fetches and stores the Workflows this User
     * is eligible to use.
     *
     * @return Workflow[]
     */
    public function getWorkflows()
    {
        if (null === $this->workflows) {
            $this->workflows = model(WorkflowModel::class)->getForUser($this);
        }

        return $this->workflows;
    }
}

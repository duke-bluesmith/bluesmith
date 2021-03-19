<?php namespace App\Entities;

use Tatter\Users\Entities\MythEntity;
use Tatter\Relations\Traits\EntityTrait;
use Tatter\Workflows\Entities\Workflow;
use Tatter\Workflows\Models\WorkflowModel;

class User extends MythEntity
{
	use EntityTrait;

	protected $table      = 'users';
	protected $primaryKey = 'id';

	/**
	 * @var Workflows[]|null
	 */
	private $workflows;

	/**
	 * Returns a full name: "First Last"
	 *
	 * @return string
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
		if (is_null($this->workflows))
		{
			$this->workflows = model(WorkflowModel::class)->getForUser($this);
		}

		return $this->workflows;
	}
}

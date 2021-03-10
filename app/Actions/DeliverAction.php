<?php namespace App\Actions;

use App\BaseAction;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Action;
use Tatter\Workflows\Models\ActionModel;
use Tatter\Workflows\Models\WorkflowModel;

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
	];

	/**
	 * Displays the delivery form.
	 *
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface
	{
		return $this->response->setBody(view('actions/deliver', [
			'job' => $this->job,
		]));
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

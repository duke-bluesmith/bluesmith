<?php namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Myth\Auth\Authorization\GroupModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use Tatter\Workflows\Models\ExplicitModel;
use Tatter\Workflows\Models\WorkflowModel;

class Users extends BaseController
{
	/**
	 * @var UserModel
	 */
	protected $model;

	/**
	 * @var string[]
	 */
	protected $helpers = ['currency'];

	/**
	 * Load the model
	 */
	public function __construct()
	{
		$this->model = model(UserModel::class);
	}

	/**
	 * Displays the compiled rows for of all Users.
	 *
	 * @return string
	 */
	public function index()
	{
		$this->model->clearCompiledRows();

		return view('users/index', [
			'title' => 'All Users',
			'rows'  => $this->model->getCompiledRows(null, 'updated_at', false),
		]);
	}

	/**
	 * Displays the compiled rows for staff User,
	 * i.e. part of a Group.
	 *
	 * @return string
	 */
	public function staff()
	{
		return view('users/index', [
			'title' => 'Staff',
			'rows'  => $this->model->getCompiledRows(function($row) {
				return is_numeric($row['group_id']);
			}, 'group')
		]);	
	}

	/**
	 * Displays a single User.
	 *
	 * @param string|int|null $userId
	 *
	 * @return string
	 */
	public function show($userId = null)
	{
		if (is_null($userId) || ! $user = $this->model->withDeleted()->find($userId))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		return view('users/show', [
			'title'     => 'User Details',
			'user'      => $user,
			'groups'    => model(GroupModel::class)->getGroupsForUser($user->id),
			'workflows' => model(WorkflowModel::class)->findAll(),
		]);
	}

	/**
	 * Adds an explicit inclusion for a User
	 * to a Workflow.
	 *
	 * @param string|int|null $userId
	 * @param string|int|null $workflowId
	 *
	 * @return RedirectResponse
	 */
	public function add_workflow($userId = null, $workflowId = null): RedirectResponse
	{
		return $this->setWorkflow($userId, $workflowId, true);
	}

	/**
	 * Adds an explicit inclusion for a User
	 * to a Workflow.
	 *
	 * @param string|int|null $userId
	 * @param string|int|null $workflowId
	 *
	 * @return RedirectResponse
	 */
	public function remove_workflow($userId = null, $workflowId = null): RedirectResponse
	{
		return $this->setWorkflow($userId, $workflowId, false);
	}

	/**
	 * Adds an explicit inclusion for a User
	 * to a Workflow.
	 *
	 * @param string|int|null $userId
	 * @param string|int|null $workflowId
	 * @param bool $permitted
	 *
	 * @return RedirectResponse
	 *
	 * @throws PageNotFoundException
	 */
	private function setWorkflow($userId = null, $workflowId = null, bool $permitted = true): RedirectResponse
	{
		if (is_null($userId) || is_null($workflowId))
		{
			throw PageNotFoundException::forPageNotFound();
		}

		// Remove any existing references
		model(ExplicitModel::class)->where([
			'user_id'     => $userId,
			'workflow_id' => $workflowId,
		])->delete();

		// Add the explicit association
		model(ExplicitModel::class)->insert([
			'user_id'     => $userId,
			'workflow_id' => $workflowId,
			'permitted'   => (int) $permitted,
		]);

		return redirect()->back()->with('success', 'Workflow ' . ($permitted ? 'allowed.' : 'restricted.'));
	}
}

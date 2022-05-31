<?php

namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Myth\Auth\Authorization\GroupModel;
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
        $this->model = model(UserModel::class); // @phpstan-ignore-line
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
            'rows'  => $this->model->getCompiledRows(static fn ($row)  => is_numeric($row['group_id']), 'group'),
        ]);
    }

    /**
     * Displays a single User.
     *
     * @param int|string|null $userId
     *
     * @return string
     */
    public function show($userId = null)
    {
        if (null === $userId || ! $user = $this->model->withDeleted()->find($userId)) {
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
     * @param int|string|null $userId
     * @param int|string|null $workflowId
     */
    public function add_workflow($userId = null, $workflowId = null): RedirectResponse
    {
        return $this->setWorkflow($userId, $workflowId, true);
    }

    /**
     * Adds an explicit inclusion for a User
     * to a Workflow.
     *
     * @param int|string|null $userId
     * @param int|string|null $workflowId
     */
    public function remove_workflow($userId = null, $workflowId = null): RedirectResponse
    {
        return $this->setWorkflow($userId, $workflowId, false);
    }

    /**
     * Adds an explicit inclusion for a User
     * to a Workflow.
     *
     * @param int|string|null $userId
     * @param int|string|null $workflowId
     *
     * @throws PageNotFoundException
     */
    private function setWorkflow($userId = null, $workflowId = null, bool $permitted = true): RedirectResponse
    {
        if (null === $userId || null === $workflowId) {
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

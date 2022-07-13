<?php

namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Models\GroupModel;
use App\Models\PermissionModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Myth\Auth\Exceptions\PermissionException;
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
            'rows'  => $this->model->getCompiledRows(static fn ($row)  => is_numeric($row['group_id']), 'group'),
        ]);
    }

    /**
     * Displays a single User.
     *
     * @param int|string|null $userId
     *
     * @return string
     *
     * @throws PageNotFoundException
     */
    public function show($userId = null)
    {
        if ($userId === null || ! $user = $this->model->withDeleted()->find($userId)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('users/show', [
            'title'     => 'User Details',
            'user'      => $user,
            'groups'    => model(GroupModel::class)->findAll(),
            'permissions' => model(PermissionModel::class)->findAll(),
            'workflows'   => model(WorkflowModel::class)->findAll(),
        ]);
    }

    /**
     * Impersonates logging in as another user.
     *
     * @param int|string|null $userId
     *
     * @return string
     *
     * @throws PageNotFoundException
     * @throws PermissionException
     */
    public function impersonate($userId = null): RedirectResponse
    {
        $this->requireAdmin();

        if ($userId === null || ! $user = $this->model->withDeleted()->find($userId)) {
            throw PageNotFoundException::forPageNotFound();
        }

        session()->set('logged_in', $user->id);
        alert('success', 'You are now impersonating ' . $user->getName());

        return redirect()->to(base_url());
    }

    /**
     * Adds a user to a group.
     *
     * @param int|string|null $userId
     * @param int|string|null $groupId
     *
     * @throws PageNotFoundException
     */
    public function add_group($userId = null, $groupId = null): RedirectResponse
    {
        $this->requireAdmin();

        if ($userId === null || $groupId === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        model(GroupModel::class)->addUserToGroup($userId, $groupId);

        return redirect()->to(site_url('manage/users/show/' . $userId))->with('message', 'User added to group.');
    }

    /**
     * Removes a user from a group.
     *
     * @param int|string|null $userId
     * @param int|string|null $groupId
     *
     * @throws PageNotFoundException
     */
    public function remove_group($userId = null, $groupId = null): RedirectResponse
    {
        $this->requireAdmin();

        model(GroupModel::class)->removeUserFromGroup($userId, $groupId);

        return redirect()->to(site_url('manage/users/show/' . $userId))->with('message', 'User removed from group.');
    }

    /**
     * Adds user workflow access.
     *
     * @param int|string|null $userId
     * @param int|string|null $workflowId
     */
    public function add_workflow($userId = null, $workflowId = null): RedirectResponse
    {
        $this->requireAdmin();

        return $this->setWorkflow($userId, $workflowId, true);
    }

    /**
     * Removes user workflow access.
     *
     * @param int|string|null $userId
     * @param int|string|null $workflowId
     */
    public function remove_workflow($userId = null, $workflowId = null): RedirectResponse
    {
        $this->requireAdmin();

        return $this->setWorkflow($userId, $workflowId, false);
    }

    /**
     * Locks a method to admin access only.
     *
     * @throws PermissionException
     */
    private function requireAdmin(): void
    {
        if (! user()->isAdmin()) {
            throw new PermissionException(lang('Auth.notEnoughPrivilege'));
        }
    }

    /**
     * Adjusts user access to a workflow.
     *
     * @param int|string|null $userId
     * @param int|string|null $workflowId
     *
     * @throws PageNotFoundException
     */
    private function setWorkflow($userId = null, $workflowId = null, bool $permitted = true): RedirectResponse
    {
        if ($userId === null || $workflowId === null) {
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

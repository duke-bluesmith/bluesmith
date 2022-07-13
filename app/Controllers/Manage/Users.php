<?php

namespace App\Controllers\Manage;

use App\Controllers\BaseController;
use App\Entities\User;
use App\Models\GroupModel;
use App\Models\PermissionModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use Myth\Auth\Exceptions\PermissionException;
use RuntimeException;
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
    protected $helpers = ['currency', 'form'];

    /**
     * Load the model
     */
    public function __construct()
    {
        $this->model = model(UserModel::class);
    }

    /**
     * Displays the compiled rows for of all Users.
     */
    public function index(): string
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
     */
    public function show($userId = null): string
    {
        return view('users/show', [
            'header' => 'User Details',
            'user'   => $this->getUser($userId),
            'groups' => model(GroupModel::class)->getGroupsForUser($userId),
        ]);
    }

    /**
     * Displays the form to edit User attributes.
     *
     * @param int|string|null $userId
     */
    public function edit($userId = null): string
    {
        $this->requireAdmin();

        return view('users/edit', [
            'header'      => 'Edit User',
            'user'        => $this->getUser($userId),
            'groups'      => model(GroupModel::class)->findAll(),
            'permissions' => model(PermissionModel::class)->findAll(),
            'workflows'   => model(WorkflowModel::class)->findAll(),
        ]);
    }

    /**
     * Updates a User.
     *
     * @param int|string|null $userId
     */
    public function update($userId = null): RedirectResponse
    {
        $this->requireAdmin();
        $user = $this->getUser($userId);

        if (! $this->model->update($user->id, $this->request->getPost())) {
            $error = implode(' ', $this->model->errors());

            return redirect()->back()->withInput()->with('error', $error);
        }

        return redirect()->to(site_url('manage/users/show/' . $userId))->with('message', 'User updated.');
    }

    /**
     * Bans a User.
     *
     * @param int|string|null $userId
     */
    public function ban($userId = null): RedirectResponse
    {
        $this->requireAdmin();

        $user = $this->getUser($userId);
        $user->ban($this->request->getPost('reason') ?? 'Administrative ban');

        if (! $this->model->save($user)) {
            $error = implode(' ', $this->model->errors());

            return redirect()->back()->withInput()->with('error', $error);
        }

        return redirect()->to(site_url('manage/users/show/' . $userId))->with('message', 'User banned.');
    }

    /**
     * Credits a User.
     *
     * @param int|string|null $userId
     */
    public function credit($userId = null): RedirectResponse
    {
        $this->requireAdmin();
        $user   = $this->getUser($userId);
        $amount = max(0, (int) $this->request->getPost('amount'));

        try {
            model(TransactionModel::class)->credit($user, $amount, 'Manual credit');
        } catch (RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('manage/users/show/' . $userId))->with('message', 'User credited.');
    }

    /**
     * Impersonates logging in as another user.
     *
     * @param int|string|null $userId
     *
     * @throws PermissionException
     */
    public function impersonate($userId = null): RedirectResponse
    {
        $this->requireAdmin();

        $user = $this->getUser($userId);
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

        return redirect()->to(site_url('manage/users/edit/' . $userId))->with('message', 'User added to group.');
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

        return redirect()->to(site_url('manage/users/edit/' . $userId))->with('message', 'User removed from group.');
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
     * Returns the User matching the input parameter.
     *
     * @param int|string|null $userId
     *
     * @throws PageNotFoundException
     */
    private function getUser($userId): User
    {
        if ($userId === null || ! $user = $this->model->withDeleted()->find($userId)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $user;
    }

    /**
     * Locks a method to admin access only.
     *
     * @throws PermissionException
     */
    private function requireAdmin(): void
    {
        /** @var User $user */
        $user = user();
        if (! $user->isAdmin()) {
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

        return redirect()->to(site_url('manage/users/edit/' . $userId))->with('success', 'Workflow ' . ($permitted ? 'allowed.' : 'restricted.'));
    }
}

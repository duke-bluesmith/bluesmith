<?php

namespace App\Actions;

use App\BaseAction;
use App\Exceptions\InviteException;
use App\Models\InviteModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Tatter\Workflows\Entities\Job;

class AssignAction extends BaseAction
{
    public const HANDLER_ID = 'clients';
    public const ATTRIBUTES = [
        'name'     => 'Project Collaborators',
        'role'     => '',
        'icon'     => 'fas fa-user-friends',
        'category' => 'Define',
        'summary'  => 'Client invites other collaboratos',
        'header'   => 'Project Collaborators',
        'button'   => 'Collaborators Invited',
    ];

    /**
     * If there are no clients then assign the current user.
     *
     * @param \App\Entities\Job $job
     */
    public static function up(Job $job): Job
    {
        if (empty($job->users)) {
            $job->addUser(user_id());
        }

        return $job;
    }

    /**
     * Displays the form
     */
    public function get(): ResponseInterface
    {
        return $this->render('actions/assign');
    }

    /**
     * Verifies at least one user has been assigned
     *
     * @return RedirectResponse|null
     */
    public function post(): ?ResponseInterface
    {
        if (empty($this->job->users)) {
            alert('warning', lang('Actions.needClients'));

            return redirect()->back();
        }

        return null;
    }

    /**
     * Takes an email address and either adds
     * a user or sends them an invite.
     *
     * @return RedirectResponse
     */
    public function put(): ResponseInterface
    {
        // All we care about is a valid email address
        $email      = service('request')->getPost('email');
        $validation = service('validation');

        // Check for a legit email
        if (! $validation->check($email, 'valid_email')) {
            alert('warning', implode('. ', $validation->getErrors()));

            return redirect()->back();
        }

        // Try to match it to an existing user
        $users = new UserModel();

        // A match! Try to add the user
        if ($user = $users->where('email', $email)->first()) {
            // Check for dupes
            if ($this->job->hasUser($user->id)) {
                alert('warning', lang('Actions.alreadyClient'));
            } elseif ($this->job->addUser($user->id)) {
                alert('success', lang('Actions.addClientSuccess', [$user->firstname]));
            } else {
                alert('error', lang('Actions.addClientFail'));
            }
        }

        // Email address not found - send an invitation
        else {
            try {
                $this->job->invite($email);
                alert('success', lang('Invite.success', [$email]));
            } catch (InviteException $e) {
                alert('error', lang('Invite.fail', [$email, $e->getMessage()]));
            }
        }

        return redirect()->back();
    }

    /**
     * Removes a user or an invitation
     *
     * @return RedirectResponse
     */
    public function delete(): ResponseInterface
    {
        if ($userId = service('request')->getPost('user_id')) {
            $this->job->removeUser($userId);
        } elseif ($inviteId = service('request')->getPost('invite_id')) {
            model(InviteModel::class)->delete($inviteId);
        } else {
            alert('error', lang('Actions.removeClientFail'));
        }

        return redirect()->back();
    }
}

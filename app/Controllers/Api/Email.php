<?php

namespace App\Controllers\Api;

use App\Entities\Invite;
use App\Entities\Job;
use App\Models\InviteModel;
use App\Models\JobModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class Email extends Controller
{
    /**
     * Handle unsubscribing
     */
    public function unsubscribe(?string $token = null): string
    {
        return 'done';
    }

    /**
     * Returns the HTML email template with inlined CSS and tokens for use by external clients
     *
     * @return string
     */
    public function template()
    {
        $inliner = new CssToInlineStyles();

        return $inliner->convert(view('emails/template'), view('emails/styles'));
    }

    /**
     * Returns an example email using the default template
     *
     * @return string
     */
    public function example()
    {
        $inliner = new CssToInlineStyles();

        return $inliner->convert(view('emails/example'), view('emails/styles'));
    }

    /**
     * Accepts an invitation and adds the user to the job.
     */
    public function invite(string $token)
    {
        if (null === $invite = model(InviteModel::class)->findByToken($token)) {
            return redirect()->to(base_url())->with('error', lang('Invite.invalid'));
        }
        if (null === $job = model(JobModel::class)->find($invite->job_id)) {
            log_message('error', 'Invitiation accepted for missing job: ' . $token);

            return redirect()->to(base_url())->with('error', lang('Invite.invalid'));
        }
        if ($invite->expired_at->isBefore(Time::now())) {
            return redirect()->to(base_url())->with('error', lang('Invite.expired'));
        }

        $user = user();

        /**
         * @var Invite $invite
         * @var Job    $job
         */

        // Check for dupes
        if ($job->hasUser($user->id)) {
            alert('info', lang('Actions.alreadyClient'));
        } elseif ($job->addUser($user->id)) {
            alert('success', lang('Actions.addClientSuccess', [$user->firstname]));
        } else {
            alert('error', lang('Actions.addClientFail'));
        }

        return redirect()->to(site_url('jobs/show/' . $job->id));
    }
}

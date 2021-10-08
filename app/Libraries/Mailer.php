<?php

namespace App\Libraries;

use App\Entities\Invoice;
use App\Entities\Job;
use App\Entities\Ledger;
use App\Entities\User;
use App\Models\JobModel;
use CodeIgniter\Email\Email as Emailer;
use Myth\Auth\Authentication\Activators\EmailActivator;
use Tatter\Outbox\Entities\Email;
use Tatter\Outbox\Models\EmailModel;
use Tatter\Outbox\Models\TemplateModel;

/**
 * Mailer Class
 *
 * Centralized library to handle all actions
 * that result in an Email trigger. Each public
 * method corresponds to an eligible email event
 * and defines the necessary input.
 * Email failure should not interrupt the flow
 * of execution, so in the event there is an
 * error it will be logged but exceptions are
 * only thrown when there is an error in the
 * configuration (i.e. a missing email Template).
 */
final class Mailer
{
    /**
     * Handles any last-minute global settings,
     * then sends the Email and deals with any errors.
     *
     * @param Emailer $emailer The Email class all ready to go
     *
     * @return int The insertID from EmailModel (0 = failed)
     */
    private static function send(Emailer $emailer): int
    {
        // Check for intercepts
        if (config('Email')->intercept) {
            // Redirect outgoing client mail
            $emailer->setTo(config('Email')->fromEmail);
        }

        if (! $emailer->send(false)) {
            log_message('error', 'Mailer was unable to send an email: ' . $emailer->printDebugger());

            return 0;
        }

        // Because the EmailModel is shared we can trust the insertID value to come from the Event trigger
        return model(EmailModel::class)->getInsertID();
    }

    //--------------------------------------------------------------------

    /**
     * Emails a summary after a new Job is submitted (via Terms Action).
     */
    public static function forNewJob(array $recipients, Job $job)
    {
        $template = model(TemplateModel::class)->findByName('New Job');

        // Prep Email to our Template
        $emailer = $template->email([
            'title'    => 'New Job Received',
            'preview'  => 'We received your job submission.',
            'job_name' => $job->name,
            'job_url'  => site_url('jobs/show/' . $job->id),
        ])->setTo($recipients);

        if ($emailId = self::send($emailer)) {
            model(JobModel::class)->addEmailToJob($emailId, $job->id);
        }
    }

    /**
     * Emails an invitation to join a job.
     *
     * @param User   $issuer    The User issuing the invitation
     * @param string $recipient Email address of the recipient
     * @param Job    $job       The Job Entity
     * @param string $token     The invitation token hash
     */
    public static function forJobInvite(User $issuer, string $recipient, Job $job, string $token)
    {
        $template = model(TemplateModel::class)->findByName('Job Invite');

        // Prep Email to our Template
        $emailer = $template->email([
            'title'       => 'Job Invitation',
            'preview'     => 'Collaborate with ' . $issuer->firstname,
            'issuer_name' => $issuer->name,
            'accept_url'  => site_url('emails/invite/' . $token),
        ]);

        // Use the Auth activator email settings, if available
        $emailer->setFrom(
            $config->userActivators[EmailActivator::class]['fromEmail'] ?? config('Email')->fromEmail,
            $config->userActivators[EmailActivator::class]['fromName'] ?? config('Email')->fromName
        )->setTo($recipient);

        if ($emailId = self::send($emailer)) {
            model(JobModel::class)->addEmailToJob($emailId, $job->id);
        }
    }

    /**
     * Emails an estimate Ledger to the recipients.
     *
     * @param array $recipients Email addresses of the recipients
     */
    public static function forEstimate(array $recipients, Job $job, Ledger $ledger)
    {
        $template = model(TemplateModel::class)->findByName('Estimate');

        // Prep Email to our Template
        $emailer = $template->email([
            'title'       => 'Job Estimate',
            'preview'     => lang('Actions.estimateReady'),
            'job_name'    => $job->name,
            'job_url'     => anchor('jobs/' . $job->id),
            'description' => nl2br($ledger->description ?: 'none provided'),
        ])->setTo($recipients);

        if ($emailId = self::send($emailer)) {
            model(JobModel::class)->addEmailToJob($emailId, $job->id);
        }
    }

    /**
     * Emails an Invoice Ledger to the recipients.
     */
    public static function forInvoice(array $recipients, Job $job, Invoice $ledger)
    {
        $template = model(TemplateModel::class)->findByName('Invoice');

        // Prep Email to our Template
        $emailer = $template->email([
            'title'       => 'Job Invoice',
            'preview'     => lang('Actions.invoiceReady'),
            'job_name'    => $job->name,
            'job_url'     => anchor('jobs/' . $job->id),
            'description' => nl2br($ledger->description ?: 'none provided'),
        ])->setTo($recipients);

        if ($emailId = self::send($emailer)) {
            model(JobModel::class)->addEmailToJob($emailId, $job->id);
        }
    }
}

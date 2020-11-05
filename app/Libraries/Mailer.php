<?php namespace App\Libraries;

use App\Entities\User;
use CodeIgniter\Email\Email;
use Tatter\Outbox\Models\TemplateModel;
use Tatter\Outbox\Outbox;

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
class Mailer
{
	/**
	 * Handles any last-minute global settings,
	 * then sends the Email and deals with any errors.
	 *
	 * @param Email $email The Email class all ready to go
	 */
	protected static function send(Email $email)
	{
		if (! $email->send(false))
		{
			log_message('error', 'Mailer was unable to send an email: ' . $email->printDebugger());
		}
	}

	//--------------------------------------------------------------------

	/**
	 * Job Invite
	 * Emails an invitation to join a job
	 *
	 * @param User $issuer      The User issuing the invitation
	 * @param string $recipient Email address of the recipient
	 * @param string $token     The invitation token hash
	 */
	public static function forJobInvite(User $issuer, string $recipient, string $token)
	{
		$template = model(TemplateModel::class)->findByName('Job Invite');

		// Prep Email to our Template
		$email = Outbox::fromTemplate($template, [
			'title'       => 'Job invitation',
			'preview'     => 'Collaborate with ' . $issuer->firstname,
			'issuer_name' => $issuer->name,
			'accept_url'  => site_url('emails/invite/' . $token),
		]);
		$email->setTo($recipient);

		self::send($email);
	}
}

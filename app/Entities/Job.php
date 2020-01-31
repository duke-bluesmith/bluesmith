<?php namespace App\Entities;

use App\Models\InviteModel;
use CodeIgniter\I18n\Time;

class Job extends \Tatter\Workflows\Entities\Job
{
	use \Tatter\Relations\Traits\EntityTrait;

	protected $table      = 'jobs';
	protected $primaryKey = 'id';

	/**
	 * Create an invitation to this job and send it to the email
	 *
	 * @param string  $to  Email address to invite
	 *
	 * @return bool  Success or failure
	 */
	public function invite(string $to): bool
	{
		$config = config('Auth');
		helper('auth');

		// Check if invitations are allowed
		if (! $config->allowInvitations)
		{
			return false;
		}

		// Make sure we have an issuer
		if (! $issuer = user())
		{
			return false;
		}

		// Build the row		
		$row = [
			'job_id'     => $this->attributes['id'],
			'email'      => $to,
			'token'      => bin2hex(random_bytes(16)),
			'created_at' => date('Y-m-d H:i:s'),
		];
		
		// Check for expirations
		if ($seconds = config('Auth')->invitationLength)
		{
			$expire = new Time("+{$seconds} seconds");
			$row['expired_at'] = $expire->toDateTimeString();
		}

		// Use the model to make the insert
		$invites = new InviteModel();
		
		if (! $invites->insert($row))
		{
			return false;
		}

		// Determine the issuer
		
		
		// Send the email
		$email = service('email');
		$emailConfig = config('Email');
		
		// Use the Auth activator email settings, if available
		$fromEmail = $config->userActivators['Myth\Auth\Authentication\Activators\EmailActivator']['fromEmail'] ?? $emailConfig->fromEmail;
		$fromName  = $config->userActivators['Myth\Auth\Authentication\Activators\EmailActivator']['fromName']  ?? $emailConfig->fromName;

		return $email->setFrom($fromEmail, $fromName)
			->setTo($to)
			->setSubject(lang('Tasks.inviteSubject', [$issuer->firstname]))
			->setMessage(view('emails/invite', ['token' => $row['token'], 'issuer' => $issuer]))
			->setMailType('html')
			->send();
	}
}

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
	 * @param string  $email  Email address to invite
	 *
	 * @return bool  Success or failure
	 */
	public function invite(string $email): bool
	{
		$config = config('Auth');

		// Check if invitations are allowed
		if (! $config->allowInvitations)
		{
			return false;
		}
		
		// Build the row		
		$row = [
			'job_id'     => $this->attributes['id'],
			'email'      => $email,
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

		// Send the email
		$email = service('email');
		$emailConfig = config('Email');
		
		// Use the Auth activator email settings, if available
		$fromEmail = $config->userActivators['Myth\Auth\Authentication\Activators\EmailActivator']['fromEmail'] ?? $emailConfig->fromEmail;
		$fromName  = $config->userActivators['Myth\Auth\Authentication\Activators\EmailActivator']['fromName']  ?? $emailConfig->fromName;

		return $email->setFrom($fromEmail, $fromName)
			->setTo($email)
			->setSubject(lang('Tasks.inviteSubject'))
			->setMessage(view('emails/invite', ['token' => $row['token']]))
			->setMailType('html')
			->send();
	}
}

<?php namespace App\Entities;

use App\Exceptions\InviteException;
use App\Libraries\Mailer;
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
	 * @param string $recipient Email address to invite
	 *
	 * @return void
	 * @throws InviteException
	 */
	public function invite(string $recipient): void
	{
		// Check if invitations are allowed
		if (! config('Auth')->allowInvitations)
		{
			throw new InviteException(lang('Invite.disabled'));
		}

		// Make sure we have an issuer
		/** @var \App\Entities\User|null $issuer */
		$issuer = user();
		if (! $issuer)
		{
			throw new InviteException(lang('Invite.noLogin'));
		}

		// Build the row		
		$row = [
			'job_id'     => $this->attributes['id'],
			'email'      => $recipient,
			'token'      => bin2hex(random_bytes(16)),
			'created_at' => date('Y-m-d H:i:s'),
		];

		// Check for expirations
		if ($seconds = config('Auth')->invitationLength)
		{
			$row['expired_at'] = (new Time("+{$seconds} seconds"))->toDateTimeString();
		}

		// Use the model to make the insert
		if (! model(InviteModel::class)->insert($row))
		{
			$error = implode(' ', model(InviteModel::class)->errors());
			throw new InviteException($error);
		}

		// Send the email
		Mailer::forJobInvite($issuer, $recipient, $this, $row['token']);
	}
}

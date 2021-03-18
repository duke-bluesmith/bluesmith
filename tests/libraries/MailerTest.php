<?php

use App\Libraries\Mailer;
use Tatter\Outbox\Entities\Email;
use Tatter\Outbox\Models\EmailModel;
use Tests\Support\DatabaseTestCase;
use App\Models\JobModel;
use App\Models\UserModel;

class MailerTest extends DatabaseTestCase
{
	public function testJobInviteAddsEmailToJob()
	{
		$job    = fake(JobModel::class);
		$issuer = fake(UserModel::class);

		Mailer::forJobInvite($issuer, 'email@example.com', $job, 'abcdefg1234567890');

		$this->seeInDatabase('emails_jobs', ['job_id' => $job->id]);
	}
}

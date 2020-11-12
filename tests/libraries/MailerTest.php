<?php

use App\Libraries\Mailer;
use Tatter\Outbox\Entities\Email;
use Tatter\Outbox\Models\EmailModel;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Fakers\JobFaker;
use Tests\Support\Fakers\UserFaker;

class MailerTest extends DatabaseTestCase
{
	public function testJobInviteAddsEmailToJob()
	{
		$job    = fake(JobFaker::class);
		$issuer = fake(UserFaker::class);

		Mailer::forJobInvite($issuer, 'email@example.com', $job, 'abcdefg1234567890');

		$this->seeInDatabase('emails_jobs', ['job_id' => $job->id]);
	}
}

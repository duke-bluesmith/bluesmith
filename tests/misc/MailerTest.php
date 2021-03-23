<?php

use App\Libraries\Mailer;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Outbox\Models\EmailModel;
use Tests\Support\ProjectTestCase;
use App\Models\JobModel;
use App\Models\UserModel;

class MailerTest extends ProjectTestCase
{
	use DatabaseTestTrait;

	public function testJobInviteAddsEmailToJob()
	{
		$job    = fake(JobModel::class);
		$issuer = fake(UserModel::class);

		Mailer::forJobInvite($issuer, 'email@example.com', $job, 'abcdefg1234567890');

		$this->seeInDatabase('emails_jobs', ['job_id' => $job->id]);
	}
}

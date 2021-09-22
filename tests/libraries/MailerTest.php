<?php

use App\Libraries\Mailer;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class MailerTest extends ProjectTestCase
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

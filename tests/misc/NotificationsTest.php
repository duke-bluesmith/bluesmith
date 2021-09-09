<?php

use App\Entities\Notification;
use App\Libraries\Notifications;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Myth\Auth\Test\Fakers\GroupFaker;
use Tatter\Chat\Models\ParticipantModel;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

class NotificationsTest extends ProjectTestCase
{
	use AuthenticationTrait;
	use DatabaseTestTrait;

	public function testDetection()
	{
		helper(['chat']);

		// Make an administrator
		$user  = fake(UserModel::class);
		$group = model(GroupFaker::class)->where('name', 'Administrators')->first();
		model(GroupFaker::class)->addUserToGroup($user->id, $group->id);

		// Create a Job with a Chat (will use $this->user from AuthenticationTrait)
		$job = fake(JobModel::class);
		chat('job-' . $job->id);

		// Say something
		$participant = model(ParticipantModel::class)->where('user_id', $this->user->id)->first();
		$messageId   = $participant->say('hello world');

		$notifications = new Notifications();

		$this->assertCount(1, $notifications);

		$notification = $notifications->getIterator()->current();

		$this->assertInstanceOf(Notification::class, $notification);
		$this->assertSame('hello world', $notification->content);
	}
}

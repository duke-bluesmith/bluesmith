<?php

use App\Entities\Notice;
use App\Libraries\Notices;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Myth\Auth\Test\Fakers\GroupFaker;
use Tatter\Chat\Models\ParticipantModel;
use Tests\Support\AuthenticationTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class NoticesTest extends ProjectTestCase
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
        $participant->say('hello world');

        // Verify it works with deleted items
        model(JobModel::class)->delete($job->id);
        model(UserModel::class)->delete($this->user->id);

        $notices = new Notices();
        $this->assertCount(1, $notices);

        $notice = $notices->getIterator()->current();
        $this->assertInstanceOf(Notice::class, $notice);
        $this->assertSame('hello world', $notice->content);
    }
}

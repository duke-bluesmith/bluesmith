<?php

namespace App\Commands;

use App\Libraries\Mailer;
use App\Models\JobModel;
use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\I18n\Time;
use RuntimeException;
use Tatter\Chat\Models\MessageModel;

class ChatMessages extends BaseCommand
{
    protected $group       = 'Task';
    protected $name        = 'email:messages';
    protected $description = 'Notifies clients when they have new chat messages.';
    protected $usage       = 'email:messages';

    public function run(array $params)
    {
        helper(['text']);

        $jobs = model(JobModel::class);

        foreach ($this->getRows() as $row) {
            if (! $job = $jobs->withDeleted()->find($row['job_id'])) {
                throw new RuntimeException('Missing Job exists in Chat messages: ' . $row['job_id']);
            }

            if ($recipients = array_column($job->users, 'email')) {
                $summary = character_limiter($row['content'], 200) ?: '[empty]';

                Mailer::forChatMessages($recipients, $job, $summary);
            }
        }
    }

    /**
     * Detects all recent staff Chat activity.
     */
    private function getRows(): array
    {
        // Get all "Staff"
        $staff = model(UserModel::class)->findStaffIds();

        $messages = [];

        // Get the last hour of messages
        $rows = model(MessageModel::class)
            ->builder()
            ->select('chat_messages.*, chat_conversations.uid, chat_participants.user_id')
            ->join('chat_conversations', 'chat_messages.conversation_id = chat_conversations.id')
            ->join('chat_participants', 'chat_messages.participant_id = chat_participants.id')
            ->like('uid', 'job-', 'after') // Bug workaround by not fully-qualifying the field
            ->where('chat_messages.created_at >', new Time('-1 hour'))
            ->get()->getResultArray();

        // Only keep staff messages without a client response
        foreach ($rows as $row) {
            [, $jobId]     = explode('-', $row['uid']);
            $row['job_id'] = $jobId;

            if (in_array($row['user_id'], $staff, true)) {
                $messages[$jobId] = $row;
            } else {
                unset($messages[$jobId]);
            }
        }

        return $messages;
    }
}

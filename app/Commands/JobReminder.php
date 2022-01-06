<?php

namespace App\Commands;

use App\Database\Seeds\InitialSeeder;
use App\Libraries\Mailer;
use App\Models\JobModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\I18n\Time;
use RuntimeException;

class JobReminder extends BaseCommand
{
    protected $group       = 'Task';
    protected $name        = 'email:reminder';
    protected $description = 'Notifies clients when they have jobs waiting on their input.';
    protected $usage       = 'email:reminder';

    public function run(array $params)
	{
		$jobs = model(JobModel::class);
		foreach ($this->getRows() as $row) {
			if (empty($row['id'])) {
				throw new RuntimeException('Missing Job ID in Job Rows');
			}
			if (! $job = $jobs->find($row['id'])) {
				throw new RuntimeException('Missing Job exists in Job Rows: ' . $row['id']);
			}

			if ($recipients = array_column($job->users, 'email')) {
				Mailer::forJobReminder($recipients, $job);
			}
		}
	}

	/**
	 * Returns all active client jobs as job rows.
	 * Split out for testing.
	 *
	 * @return array<string, mixed>
	 */
	public function getRows()
	{
		// Get all active client jobs
		$filter = static function ($row) {
			if ($row['deleted_at'] !== null) {
				return false;
			}

			if ($row['stage_id'] === null) {
				return false;
			}

			if ($row['role'] !== '') {
				return false;
			}

			if ($row['role'] !== '') {
				return false;
			}

			if ($row['updated_at']->isAfter(Time::today())) {
				return false;
			}

            return true;
        };

		return model(JobModel::class)->getCompiledRows($filter);
	}
}

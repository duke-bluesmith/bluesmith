<?php

namespace App\Models;

use App\Entities\Job;
use CodeIgniter\Test\Fabricator;
use Faker\Generator;
use Tatter\Permits\Traits\PermitsTrait;
use Tatter\Relations\Traits\ModelTrait;
use Tatter\Workflows\Entities\Job as BaseJob;
use Tatter\Workflows\Models\JobModel as BaseJobModel;

/**
 * Class JobModel
 *
 * Extension of the Workflows model to add Relations and Permits
 */
class JobModel extends BaseJobModel
{
    use CompiledRowsTrait;
    use PermitsTrait;
    use ModelTrait;

    protected $with          = ['options'];
    protected $returnType    = Job::class;
    protected $allowedFields = ['name', 'summary', 'workflow_id', 'stage_id', 'material_id'];

    protected $afterInsert = ['clearCompiledRows', 'logInsert'];
    protected $afterUpdate = ['clearCompiledRows', 'logUpdate'];
    protected $afterDelete = ['clearCompiledRows'];

    /**
     * Permits
     * 6 Domain list and create
     * 6 Owner  read, write
     * 6 Group  read, write
     * 0 World  no read, no write
     */
    protected $mode = 06660;

    // Table that joins this model's objects to its users
    protected $usersPivot = 'jobs_users';

    // Name of this object's ID in the pivot tables
    protected $pivotKey = 'job_id';

    /**
     * Overrides the library's validation.
     */
    protected function initialize()
    {
        // Make `summary` a required field
        $this->validationRules['summary'] = 'required|max_length[255]';
    }

    /**
     * Associates a new Job with its User.
     */
    protected function logInsert(array $eventData)
    {
        parent::logInsert($eventData);

        if ($eventData['result'] && $userId = user_id()) {
            $this->addUserToJob($userId, $eventData['id']);
        }

        return $eventData;
    }

    /**
     * Assigns a single Email to a single job.
     */
    public function addEmailToJob(int $emailId, int $jobId): bool
    {
        return (bool) $this->db->table('emails_jobs')->insert([
            'email_id' => (int) $emailId,
            'job_id'   => (int) $jobId,
        ]);
    }

    /**
     * Assigns a single User to a single job.
     */
    public function addUserToJob(int $userId, int $jobId): bool
    {
        return (bool) $this->db->table('jobs_users')->insert([
            'job_id'     => (int) $jobId,
            'user_id'    => (int) $userId,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Fetch or build the compiled rows for browsing,
     * applying filters, and sorting.
     *
     * @return array[]
     */
    protected function fetchCompiledRows(): array
    {
        return $this->builder()
            ->select('jobs.*, methods.name AS method, users.id AS user_id, users.firstname, users.lastname, workflows.name AS workflow, actions.name AS action, actions.role')
            ->join('materials', 'jobs.material_id = materials.id', 'left')
            ->join('methods', 'materials.method_id = methods.id', 'left')
            ->join('jobs_users', 'jobs.id = jobs_users.job_id', 'left')
            ->join('users', 'jobs_users.user_id = users.id', 'left')
            ->join('workflows', 'jobs.workflow_id = workflows.id')
            ->join('stages', 'jobs.stage_id = stages.id', 'left')
            ->join('actions', 'stages.action_id = actions.id', 'left')
            ->get()->getResultArray();
    }

    /**
     * Removes cached Job rows and Notices.
     * Must be compatible with model events.
     */
    public function clearCompiledRows(?array $eventData = null): array
    {
        cache()->delete($this->table . 'rows');
        cache()->delete('notices');

        return $eventData ?? [];
    }

    /**
     * Faked data for Fabricator.
     *
     * @return Job
     */
    public function fake(Generator &$faker): BaseJob
    {
        return new Job([
            'name'        => $faker->catchPhrase,
            'summary'     => $faker->sentence,
            'workflow_id' => mt_rand(1, Fabricator::getCount('workflows') ?: 4),
            'stage_id'    => mt_rand(1, Fabricator::getCount('stages') ?: 99),
            'material_id' => mt_rand(1, Fabricator::getCount('materials') ?: 35),
        ]);
    }
}

<?php

use App\Entities\Job;
use App\Libraries\Wizard;
use App\Models\JobModel;
use App\Models\MaterialModel;
use App\Models\MethodModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class WizardTest extends ProjectTestCase
{
    use DatabaseTestTrait;

    /**
     * @var Job
     */
    private $job;

    /**
     * Creates a test Job.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create the test objects once
        if ($this->job === null) {
            // Create the necessary relations (Fabricator will assign them)
            fake(MethodModel::class);
            fake(MaterialModel::class);

            $this->job = fake(JobModel::class, [
                'name'        => 'staff job',
                'workflow_id' => 1,
                'stage_id'    => 6, // charges
            ]);
        }
    }

    public function testFromJobCreatesWizard()
    {
        $result = Wizard::fromJob($this->job);

        $this->assertInstanceOf(Wizard::class, $result);
        $this->assertIsString($result->__toString());
    }
}

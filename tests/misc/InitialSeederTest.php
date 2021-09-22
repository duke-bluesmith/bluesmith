<?php

use App\Database\Seeds\InitialSeeder;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Outbox\Entities\Template;
use Tatter\Outbox\Models\TemplateModel;
use Tatter\Workflows\Models\WorkflowModel;
use Tests\Support\ProjectTestCase;

/**
 * Tests for the intial seeder
 *
 * @internal
 */
final class InitialSeederTest extends ProjectTestCase
{
    use DatabaseTestTrait;

    protected $seed = '';

    public function testCreatesDefaultWorkflow()
    {
        $this->dontSeeInDatabase('workflows', ['category' => 'Core']);

        $this->seed(InitialSeeder::class);

        $this->seeInDatabase('workflows', ['category' => 'Core']);
    }

    public function testCreatesInitialStages()
    {
        $this->seed(InitialSeeder::class);

        $result = model(WorkflowModel::class)->first()->stages;

        $this->assertCount(13, $result);
        $this->assertSame('options', $result[3]->action->uid);
    }

    public function testCreatesInviteEmailTemplate()
    {
        $this->seed(InitialSeeder::class);

        $template = model(TemplateModel::class)->findByName('Job Invite');

        $this->assertInstanceOf(Template::class, $template);
    }
}

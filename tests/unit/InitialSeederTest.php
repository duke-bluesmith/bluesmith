<?php

use Tatter\Outbox\Entities\Template;
use Tatter\Outbox\Models\TemplateModel;
use Tatter\Workflows\Models\WorkflowModel;
use Tests\Support\DatabaseTestCase;
use Tests\Support\Simulator;

/**
 * Tests for the intial seeder
 */
class InitialSeederTest extends DatabaseTestCase
{
	public function testCreatesDefaultWorkflow()
	{
		$this->seeInDatabase('workflows', ['category' => 'Core']);
	}

	public function testCreatesInitialStages()
	{
		$workflow = model(WorkflowModel::class)->first();

		$result = $workflow->stages;

		$this->assertCount(13, $result);
		$this->assertEquals('options', $result[3]->action->uid);
	}

	public function testCreatesInviteEmailTemplate()
	{
		$template = model(TemplateModel::class)->findByName('Job Invite');

		$this->assertInstanceOf(Template::class, $template);
	}
}

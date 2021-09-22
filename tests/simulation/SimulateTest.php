<?php

use App\Models\MethodModel;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\ProjectTestCase;

/**
 * Tests for the Simulate Command
 *
 * @internal
 */
final class SimulateTest extends ProjectTestCase
{
    use DatabaseTestTrait;

    /**
     * @slowThreshold 3000
     */
    public function testTruncatesTables()
    {
        model(MethodModel::class)->insert(['name' => 'foobar']);

        command('simulate');

        $this->dontSeeInDatabase('methods', ['name' => 'foobar']);
    }

    /**
     * @slowThreshold 3000
     */
    public function testCreatesRestrictedWorkflow()
    {
        command('simulate');

        $this->seeInDatabase('workflows', ['role' => 'manageContent']);
    }
}

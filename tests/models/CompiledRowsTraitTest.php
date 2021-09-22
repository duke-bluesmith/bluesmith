<?php

namespace App\Models;

use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Mock\MockCompiledRowsModel;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class CompiledRowsTraitTest extends ProjectTestCase
{
    use DatabaseTestTrait;

    // Initialize the database once
    protected $migrateOnce = true;
    protected $seedOnce    = true;

    /**
     * @var MockCompiledRowsModel
     */
    private $model;

    /**
     * Creates an anonymous traited model
     * for easy trait access.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new MockCompiledRowsModel();
    }

    public function testGet()
    {
        $result = $this->model->getCompiledRows();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertSame(['id', 'name', 'created_at'], array_keys($result[0]));
    }

    public function testClear()
    {
        cache()->save('bananasrows', ['foo' => 'bar']);

        $this->model->clearCompiledRows();
        $result = $this->model->getCompiledRows();

        $this->assertArrayNotHasKey('foo', $result);
    }

    public function testCreatesCache()
    {
        $this->assertNull(cache()->get('bananasrows'));

        $this->model->getCompiledRows();

        $this->assertNotNull(cache()->get('bananasrows'));
    }

    public function testUsesCache()
    {
        $expected = ['foo' => 'bar'];
        cache()->save('bananasrows', $expected);

        $result = $this->model->getCompiledRows();

        $this->assertSame($expected, $result);
    }

    public function testEventsClearCache()
    {
        foreach (['afterInsert', 'afterUpdate', 'afterDelete'] as $event) {
            cache()->save('bananasrows', ['foo' => 'bar']);
            $this->model->trigger($event);
            $this->assertNull(cache()->get('bananasrows'));
        }
    }
}

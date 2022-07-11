<?php

namespace App\Actions;

use CodeIgniter\Events\Events;
use CodeIgniter\Test\DatabaseTestTrait;
use Tatter\Files\Models\FileModel;
use Tests\Support\ActionTrait;
use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class FilesTest extends ProjectTestCase
{
    use ActionTrait;
    use DatabaseTestTrait;

    protected $namespace = [
        'Tatter\Files',
        'Tatter\Outbox',
        'Tatter\Settings',
        'Tatter\Themes',
        'Tatter\Workflows',
        'Myth\Auth',
        'App',
    ];

    /**
     * UID of the Action to test
     *
     * @var string
     */
    protected $actionUid = 'files';

    protected function setUp(): void
    {
        parent::setUp();

        config('Files')->storagePath = SUPPORTPATH . 'Files/';
    }

    public function testUploadAlertsVolumeFail()
    {
        $expected = [
            'class' => 'warning',
            'text'  => lang('Actions.volumeFail'),
        ];

        $file = fake(FileModel::class, [
            'localname'  => 'invalid.stl',
            'clientname' => 'invalid.stl',
            'size'       => 12345,
        ]);
        Events::trigger('upload', $file);

        $result = session()->get('alerts-queue');

        $this->assertSame([$expected], $result);
    }
}

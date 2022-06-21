<?php

use Tests\Support\ProjectTestCase;

/**
 * @internal
 */
final class LegacyRoutesTest extends ProjectTestCase
{
    /**
     * @dataProvider legacyRouteProvider
     */
    public function testRoutes(string $route, string $redirect)
    {
        require APPPATH . 'Config/Routes.php';
        $result = $routes->getRoutes();

        $this->assertSame($redirect, $result[$route]);
    }

    public function legacyRouteProvider()
    {
        return [
            ['jobs', 'account/jobs'],
            ['jobs/index', 'account/jobs'],
            ['jobs/add', 'jobs/new'],
        ];
    }
}

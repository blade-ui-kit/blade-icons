<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Svg;

class FilesystemDiskTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_an_icon()
    {
        $factory = $this->prepareSets([], ['default' => [
            'disk' => 'external-disk',
            'path' => '/',
        ]]);

        $icon = $factory->svg('cake');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('cake', $icon->name());
    }

    /** @test */
    public function it_can_still_retrieve_an_icon_from_a_local_set()
    {
        $factory = $this->prepareSets([], ['default' => [
            'disk' => 'external-disk',
            'path' => '/',
        ]]);

        $icon = $factory->svg('zondicon-flag');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('flag', $icon->name());
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.external-disk', [
            'driver' => 'local',
            'root' => __DIR__.'/resources/external-disk',
        ]);
    }
}

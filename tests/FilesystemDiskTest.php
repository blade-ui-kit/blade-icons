<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Factory;
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

    /** @test */
    public function it_can_render_an_icon_component()
    {
        $this->prepareSets([], ['default' => [
            'disk' => 'external-disk',
            'path' => '/',
        ]]);

        $view = $this->blade('<x-icon-cake/>');

        $expected = <<<'HTML'
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function the_local_filesystem_is_used_for_the_disk_option_with_an_empty_string()
    {
        $factory = $this->prepareSets([], ['default' => [
            'disk' => '',
            'path' => $this->app->basePath('resources'),
        ]]);

        $this->assertInstanceOf(Factory::class, $factory);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.external-disk', [
            'driver' => 'local',
            'root' => __DIR__.'/resources/external-disk',
        ]);
    }
}

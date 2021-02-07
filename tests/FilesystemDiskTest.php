<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Factory;
use BladeUI\Icons\Svg;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Filesystem\Filesystem;

class FilesystemDiskTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_an_icon()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('cake');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('cake', $icon->name());
    }

    /** @test */
    public function it_can_still_retrieve_an_icon_from_a_local_set()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('zondicon-flag');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('flag', $icon->name());
    }

    protected function prepareSets(string $defaultClass = '', array $setClasses = []): Factory
    {
        $factory = (new Factory(new Filesystem(), $defaultClass, $this->app->make(FilesystemFactory::class)))
            ->add('default', [
                'disk' => 'external-disk',
                'path' => '/',
                'prefix' => 'icon',
                'class' => $setClasses['default'] ?? '',
            ])
            ->add('zondicons', [
                'path' => __DIR__.'/resources/zondicons',
                'prefix' => 'zondicon',
                'class' => $setClasses['zondicons'] ?? '',
            ]);

        return $this->app->instance(Factory::class, $factory);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.external-disk', [
            'driver' => 'local',
            'root' => __DIR__.'/resources/external-disk',
        ]);
    }
}

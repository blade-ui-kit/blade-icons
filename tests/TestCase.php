<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Factory;
use BladeUI\Icons\IconsManifest;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    use InteractsWithViews;

    protected function prepareSets(array $config = [], array $setOptions = []): Factory
    {
        $factory = new Factory(
            new Filesystem(),
            $this->app->make(IconsManifest::class),
            $this->app->make(FilesystemFactory::class),
            $config,
        );

        $factory = $factory
            ->add('default', array_merge([
                'path' => __DIR__.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'svg',
                'prefix' => 'icon',
            ], $setOptions['default'] ?? []))
            ->add('zondicons', array_merge([
                'path' => __DIR__.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'zondicons',
                'prefix' => 'zondicon',
            ], $setOptions['zondicons'] ?? []));

        return $this->app->instance(Factory::class, $factory);
    }

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

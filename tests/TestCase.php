<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Factory;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function prepareSets(array $config = [], array $setOptions = []): Factory
    {
        $factory = (new Factory(new Filesystem(), $this->app->make(FilesystemFactory::class), $config))
            ->add('default', array_merge([
                'path' => __DIR__.'/resources/svg',
                'prefix' => 'icon',
            ], $setOptions['default'] ?? []))
            ->add('zondicons', array_merge([
                'path' => __DIR__.'/resources/zondicons',
                'prefix' => 'zondicon',
            ], $setOptions['zondicons'] ?? []));

        return $this->app->instance(Factory::class, $factory);
    }

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

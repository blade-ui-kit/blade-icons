<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Factory;
use Illuminate\Filesystem\Filesystem;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function prepareSets(string $defaultClass = '', array $setClasses = []): Factory
    {
        $factory = (new Factory(new Filesystem(), $defaultClass))
            ->add('default', [
                'path' => __DIR__.'/resources/svg',
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

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

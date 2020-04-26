<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Factory;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function prepareSets(string $defaultClass = ''): Factory
    {
        $this->app->make('config')->set('blade-icons.class', $defaultClass);

        return $this->app->make(Factory::class)
            ->add('default', [
                'path' => __DIR__ . '/resources/svg',
                'prefix' => 'icon',
            ])
            ->add('zondicons', [
                'path' => __DIR__ . '/resources/zondicons',
                'prefix' => 'zondicon',
            ]);
    }

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

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
                'component-prefix' => 'icon',
                'sprite-sheet' => [
                    'path' => __DIR__ . '/resources/sprite-sheet.svg',
                ],
            ])
            ->add('zondicons', [
                'path' => __DIR__ . '/resources/zondicons',
                'component-prefix' => 'zondicon',
            ])
            ->add('test', [
                'sprite-sheet' => [
                    'url' => 'http://example.com',
                ],
            ]);
    }

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

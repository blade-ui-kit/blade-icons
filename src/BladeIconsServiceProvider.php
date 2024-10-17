<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Components\Icon;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class BladeIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->registerFactory();
        $this->registerManifest();
    }

    public function boot(): void
    {
        $this->bootCommands();
        $this->bootDirectives();
        $this->bootIconComponent();
        $this->bootPublishing();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-icons.php', 'blade-icons');
    }

    private function registerFactory(): void
    {
        $this->app->singleton(Factory::class, function (Application $app) {
            $config = $app->make('config')->get('blade-icons', []);

            $factory = new Factory(
                new Filesystem,
                $app->make(IconsManifest::class),
                $app->make(FilesystemFactory::class),
                $config,
            );

            foreach ($config['sets'] ?? [] as $set => $options) {
                if (! isset($options['disk']) || ! $options['disk']) {
                    $paths = $options['paths'] ?? $options['path'] ?? [];

                    $options['paths'] = array_map(
                        fn ($path) => $app->basePath($path),
                        (array) $paths,
                    );
                }

                $factory->add($set, $options);
            }

            return $factory;
        });

        $this->callAfterResolving(ViewFactory::class, function ($view, Application $app) {
            $app->make(Factory::class)->registerComponents();
        });
    }

    private function registerManifest(): void
    {
        $this->app->singleton(IconsManifest::class, function (Application $app) {
            return new IconsManifest(
                new Filesystem,
                $this->manifestPath(),
                $app->make(FilesystemFactory::class),
            );
        });
    }

    private function manifestPath(): string
    {
        return $this->app->bootstrapPath('cache/blade-icons.php');
    }

    private function bootCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\CacheCommand::class,
                Console\ClearCommand::class,
            ]);

            if (method_exists($this, 'optimizes')) {
                $this->optimizes(
                    'icons:cache',
                    'icons:clear',
                    'blade-icons'
                );
            }
        }
    }

    private function bootDirectives(): void
    {
        Blade::directive('svg', fn ($expression) => "<?php echo e(svg($expression)); ?>");
    }

    private function bootIconComponent(): void
    {
        if ($name = config('blade-icons.components.default')) {
            Blade::component($name, Icon::class);
        }
    }

    private function bootPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blade-icons.php' => $this->app->configPath('blade-icons.php'),
            ], 'blade-icons');
        }
    }
}

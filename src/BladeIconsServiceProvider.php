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
    }

    public function boot(): void
    {
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

            $factory = new Factory(new Filesystem(), $app->make(FilesystemFactory::class), $config);

            foreach ($config['sets'] ?? [] as $set => $options) {
                if (! isset($options['disk'])) {
                    $options['path'] = $app->basePath($options['path']);
                }

                $options['paths'] = array_map(function ($path) use ($app) {
                    return $app->basePath($path);
                }, $options['paths'] ?? (array) $options['path']);

                $factory->add($set, $options);
            }

            return $factory;
        });

        $this->callAfterResolving(ViewFactory::class, function ($view, Application $app) {
            $app->make(Factory::class)->registerComponents();
        });
    }

    private function bootIconComponent(): void
    {
        if ($name = config('blade-icons.components.default')) {
            Blade::component($name, Icon::class);
        }
    }

    private function bootDirectives(): void
    {
        Blade::directive('svg', function ($expression) {
            return "<?php echo e(svg($expression)); ?>";
        });
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

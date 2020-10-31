<?php

declare(strict_types=1);

namespace BladeUI\Icons;

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
        $this->bootPublishing();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-icons.php', 'blade-icons');
    }

    private function registerFactory(): void
    {
        $this->app->singleton(Factory::class, function (Application $app) {
            $config = $app->make('config')->get('blade-icons');

            $factory = new Factory(new Filesystem(), $config['class'] ?? '');

            foreach ($config['sets'] ?? [] as $set => $options) {
                $options['path'] = $app->basePath($options['path']);

                $factory->add($set, $options);
            }

            return $factory;
        });

        $this->callAfterResolving(ViewFactory::class, function ($view, Application $app) {
            $app->make(Factory::class)->registerComponents();
        });
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

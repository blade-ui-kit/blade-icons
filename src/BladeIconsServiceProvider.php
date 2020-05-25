<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use Illuminate\Contracts\Container\Container;
use Illuminate\Filesystem\Filesystem;
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
        $this->bootIconSets();
        $this->bootViews();
        $this->bootDirectives();
        $this->bootPublishing();
    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blade-icons.php', 'blade-icons');
    }

    private function registerFactory(): void
    {
        $this->app->singleton(Factory::class, function (Container $container) {
            $config = $container->make('config')->get('blade-icons');

            return new Factory(new Filesystem(), $config['class']);
        });
    }

    private function bootIconSets(): void
    {
        $config = $this->app->make('config')->get('blade-icons');
        $factory = $this->app->make(Factory::class);

        foreach ($config['sets'] as $set => $options) {
            $options['path'] = $this->app->basePath($options['path']);

            $factory->add($set, $options);
        }
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'blade-icons');
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
                __DIR__ . '/../config/blade-icons.php' => $this->app->configPath('blade-icons.php'),
            ], 'blade-icons');
        }
    }
}

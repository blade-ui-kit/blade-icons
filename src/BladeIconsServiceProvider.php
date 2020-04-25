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
        $this->mergeConfigFrom(__DIR__.'/../config/blade-icons.php', 'blade-icons');

        $this->registerFactory();
    }

    private function registerFactory(): void
    {
        $this->app->singleton(Factory::class, function (Container $container) {
            $config = $container->make('config')->get('blade-icons');

            $factory = new Factory(new Filesystem(), $config['class']);

            foreach ($config['sets'] as $set => $options) {
                if (isset($options['path'])) {
                    $options['path'] = $this->app->basePath($options['path']);
                }

                $factory->add($set, $options);
            }

            return $factory;
        });
    }

    public function boot(): void
    {
        Blade::directive('svg', function ($expression) {
            return "<?php echo e(svg($expression)); ?>";
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/blade-icons.php' => $this->app->configPath('blade-icons.php'),
            ], 'blade-icons');
        }
    }
}

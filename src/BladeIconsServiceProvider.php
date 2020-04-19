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

        $this->app->singleton(Factory::class, function (Container $container) {
            $class = $container->make('config')->get('blade-icons.class', '');

            return new Factory(new Filesystem(), $class);
        });
    }

    public function boot(): void
    {
        $this->bootFactory();
        $this->bootDirectives();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/blade-icons.php' => $this->app->configPath('blade-icons.php'),
            ], 'blade-icons');
        }
    }

    private function bootFactory(): void
    {
        $factory = $this->app->make(Factory::class);
        $config = $this->app->make('config')->get('blade-icons');

        foreach ($config['sets'] as $set => $options) {
            if (isset($options['path'])) {
                $options['path'] = $this->app->basePath($options['path']);
            }

            if (isset($options['sprite-sheet']['path'])) {
                $options['sprite-sheet']['path'] = $this->app->basePath($options['sprite-sheet']['path']);
            }

            $factory->add($set, $options);
        }
    }

    private function bootDirectives(): void
    {
        Blade::directive('svg', function ($expression) {
            return "<?php echo e(svg($expression)); ?>";
        });

        Blade::directive('sprite', function ($expression) {
            return "<?php echo e(sprite($expression)); ?>";
        });

        Blade::directive('spriteSheet', function ($expression) {
            return "<?php echo e(sprite_sheet($expression)); ?>";
        });
    }
}

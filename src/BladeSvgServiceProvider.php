<?php

namespace BladeSvg;

use BladeSvg\IconFactory;
use Illuminate\Support\ServiceProvider;

class BladeSvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app(IconFactory::class)->registerBladeTag();

        $this->publishes([
            __DIR__.'/../config/blade-svg.php' => config_path('blade-svg.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(IconFactory::class, function () {
            $config = array_merge(config('blade-svg', []), [
                'spritesheet_path' => config('blade-svg.spritesheet_path') ? base_path(config('blade-svg.spritesheet_path')) : null,
                'icon_path' => config('blade-svg.icon_path') ? base_path(config('blade-svg.icon_path')) : null,
            ]);
            return new IconFactory($config);
        });
    }
}

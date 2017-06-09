<?php

namespace BladeSvg;

use BladeSvg\SvgFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class BladeSvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app(SvgFactory::class)->registerBladeTag();

        $this->publishes([
            __DIR__.'/../config/blade-svg.php' => config_path('blade-svg.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(SvgFactory::class, function () {

            $config = Collection::make(config('blade-svg', []))->merge([
                'spritesheet_path' => base_path(config('blade-svg.spritesheet_path')),
                'svg_path' => base_path(config('blade-svg.svg_path', config('blade-svg.icon_path'))),
            ])->all();

            return new SvgFactory($config);
        });
    }
}

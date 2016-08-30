<?php

namespace BladeSvg;

use BladeSvg\IconFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeSvgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::extend(function ($html) {
            return preg_replace_callback('/\@icon((\(.+\)\-\>.+)*\(.+\))/', function ($matches) {
                return '<?php echo svg_icon'.$matches[1].'; ?>';
            }, $html);
        });

        $this->publishes([
            __DIR__.'/../config/blade-svg.php' => config_path('blade-svg.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(IconFactory::class, function () {
            $config = array_merge(config('blade-svg'), [
                'spritesheet_path' => config('blade-svg.spritesheet_path') ? base_path(config('blade-svg.spritesheet_path')) : null,
                'icon_path' => config('blade-svg.icon_path') ? base_path(config('blade-svg.icon_path')) : null,
            ]);
            return new IconFactory($config);
        });
    }
}

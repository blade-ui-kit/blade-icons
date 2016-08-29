<?php

namespace Zondicons;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ZondiconsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::extend(function ($html) {
            return preg_replace_callback('/\@icon((\(.+\)\-\>.+)*\(.+\))/', function ($matches) {
                return '<?php echo zondicon'.$matches[1].'; ?>';
            }, $html);
        });
        /*
        Blade::directive('icon', function ($expression) {
            return "<?php echo app('\Zondicons\Zondicon')->icon($expression); ?>";
        });
        */

        $this->publishes([
            __DIR__.'/../config/zondicons.php' => config_path('zondicons.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ZondiconFactory::class, function () {
            return new ZondiconFactory(config('zondicons'));
        });
    }
}

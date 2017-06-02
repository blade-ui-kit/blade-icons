<?php

namespace BladeSvg;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;

class SvgFactory
{
    private $files;
    private $svgCache;
    private $config = [
        'inline' => false,
        'class' => 'icon',
        'sprite_prefix' => '',
    ];

    public function __construct($config = [], $filesystem = null)
    {
        $this->config = Collection::make(array_merge($this->config, $config));
        $this->svgCache = Collection::make();
        $this->files = $filesystem ?: new Filesystem;
    }

    public function registerBladeTag()
    {
        Blade::directive('icon', function ($expression) {
            return "<?php echo e(svg_image($expression)); ?>";
        });

        Blade::directive('svg', function ($expression) {
            return "<?php echo e(svg_image($expression)); ?>";
        });
    }

    private function svgPath()
    {
        return $this->config->get('svg_path', function () {
            throw new Exception('No svg_path set!');
        });
    }

    private function spritesheetPath()
    {
        return $this->config->get('spritesheet_path', function () {
            throw new Exception('No spritesheet_path set!');
        });
    }

    public function spritesheetUrl()
    {
        return $this->config->get('spritesheet_url', '');
    }

    public function spritesheet()
    {
        return new HtmlString(
            sprintf(
                '<div style="height: 0; width: 0; position: absolute; visibility: hidden;">%s</div>',
                file_get_contents($this->spritesheetPath())
            )
        );
    }

    public function svg($name, $class = '', $attrs = [])
    {
        if (is_array($class)) {
            $attrs = $class;
            $class = '';
        }

        $attrs = array_merge([
            'class' => $this->buildClass($class),
        ], $attrs);

        return new Svg($name, $this->renderMode(), $this, $attrs);
    }

    public function spriteId($svgName)
    {
        return "{$this->spritePrefix()}{$svgName}";
    }

    private function spritePrefix()
    {
        return $this->config->get('sprite_prefix');
    }

    private function renderMode()
    {
        return $this->config['inline'] ? 'inline' : 'sprite';
    }

    private function buildClass($class)
    {
        return trim(sprintf('%s %s', $this->config['class'], $class));
    }

    public function getSvg($name)
    {
        return $this->svgCache->get($name, function () use ($name) {
            return $this->svgCache[$name] = trim($this->files->get(sprintf('%s/%s.svg', rtrim($this->svgPath()), str_replace('.', '/', $name))));
        });
    }
}

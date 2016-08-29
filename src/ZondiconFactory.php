<?php

namespace Zondicons;

use Illuminate\Support\Collection;

class ZondiconFactory
{
    private $config = [
        'inline' => false,
        'class' => 'icon'
    ];

    private $svgCache;

    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
        $this->svgCache = Collection::make();
    }

    public function icon($name, $class = '', $attrs = [])
    {

        return $this->config['inline'] ? $this->inline($name, $class, $attrs) : $this->sprite($name, $class, $attrs);
    }

    public function inline($name, $class = '', $attrs = [])
    {
        return str_replace(
            '<svg',
            sprintf('<svg class="%s"%s', $this->buildClass($class), $this->renderAttributes($attrs)),
            $this->getIconSvg($name)
        );
    }

    public function sprite($name, $class = '', $attrs = [])
    {
        return vsprintf('<svg class="%s"%s><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#%s"></use></svg>', [
            $this->buildClass($class),
            $this->renderAttributes($attrs),
            $name
        ]);
    }

    private function buildClass($class = '')
    {
        return trim(sprintf('%s %s', $this->config['class'], $class));
    }

    private function renderAttributes($attrs)
    {
        if (count($attrs) == 0) {
            return '';
        }

        return ' '.collect($attrs)->map(function ($value, $key) {
            return sprintf('%s="%s"', $key, $value);
        })->implode(' ');
    }

    private function getIconSvg($name)
    {
        return $this->svgCache->get($name, function () use ($name) {
            return $this->svgCache[$name] = file_get_contents(sprintf('%s/../resources/icons/%s.svg', __DIR__, $name));
        });
    }
}

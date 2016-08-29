<?php

namespace Zondicons;

use Illuminate\Support\Collection;

class Zondicon
{
    private $icon;
    private $config;
    private $factory;
    private $class = '';
    private $attrs = [];

    public function __construct($icon, $config, $factory, $class = '')
    {
        $this->icon = $icon;
        $this->config = $config;
        $this->factory = $factory;
        $this->class = $class;
    }

    public function __toString()
    {
        return $this->config['inline'] ? $this->renderInline() : $this->renderFromSprite();
    }

    public function __call($method, $args)
    {
        $this->attrs[] = [
            'attribute' => snake_case($method, '-'),
            'value' => count($args) ? $args[0] : null
        ];
        return $this;
    }

    public function inline()
    {
        $this->config['inline'] = true;
        return $this;
    }

    public function sprite()
    {
        $this->config['inline'] = false;
        return $this;
    }

    public function renderInline()
    {
        return str_replace(
            '<svg',
            sprintf('<svg class="%s"%s', $this->buildClass(), $this->renderAttributes()),
            $this->factory->getSvg($this->icon)
        );
    }

    public function renderFromSprite()
    {
        return vsprintf('<svg class="%s"%s><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-%s"></use></svg>', [
            $this->buildClass(),
            $this->renderAttributes(),
            $this->icon
        ]);
    }

    private function buildClass()
    {
        return trim(sprintf('%s %s', $this->config['class'], $this->class));
    }

    private function renderAttributes()
    {
        if (count($this->attrs) == 0) {
            return '';
        }

        return ' '.collect($this->attrs)->map(function ($attr) {
            if ($attr['value'] === null) {
                return $attr['attribute'];
            }
            return sprintf('%s="%s"', $attr['attribute'], $attr['value']);
        })->implode(' ');
    }
}

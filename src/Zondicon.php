<?php

namespace Zondicons;

use Illuminate\Support\Collection;

class Zondicon
{
    private $icon;
    private $renderMode;
    private $factory;
    private $attrs = [];

    public function __construct($icon, $renderMode, $factory, $attrs = [])
    {
        $this->icon = $icon;
        $this->renderMode = $renderMode;
        $this->factory = $factory;
        $this->attrs = $attrs;
    }

    public function __toString()
    {
        return call_user_func([
            'inline' => [$this, 'renderInline'],
            'sprite' => [$this, 'renderFromSprite'],
        ][$this->renderMode]);
    }

    public function __call($method, $args)
    {
        $this->attrs[snake_case($method, '-')] = array_merge($args, [true])[0];
        return $this;
    }

    public function inline()
    {
        $this->renderMode = 'inline';
        return $this;
    }

    public function sprite()
    {
        $this->renderMode = 'sprite';
        return $this;
    }

    public function renderInline()
    {
        return str_replace(
            '<svg',
            sprintf('<svg%s', $this->renderAttributes()),
            $this->factory->getSvg($this->icon)
        );
    }

    public function renderFromSprite()
    {
        return vsprintf('<svg%s><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-%s"></use></svg>', [
            $this->renderAttributes(),
            $this->icon
        ]);
    }

    private function renderAttributes()
    {
        if (count($this->attrs) == 0) {
            return '';
        }

        return ' '.collect($this->attrs)->map(function ($value, $attr) {
            if ($value === true) {
                return $attr;
            }
            return sprintf('%s="%s"', $attr, $value);
        })->implode(' ');
    }
}

<?php

namespace Zondicons;

use Illuminate\Support\Collection;

class ZondiconFactory
{
    private $config = [
        'inline' => false,
        'class' => 'zondicon'
    ];

    private $svgCache;

    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
        $this->svgCache = Collection::make();
    }

    public function icon($name, $class = '')
    {
        return new Zondicon($name, $this->config, $this, $class);
    }

    public function getSvg($name)
    {
        return $this->svgCache->get($name, function () use ($name) {
            return $this->svgCache[$name] = file_get_contents(sprintf('%s/../resources/icons/%s.svg', __DIR__, $name));
        });
    }
}

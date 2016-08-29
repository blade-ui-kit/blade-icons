<?php

namespace Zondicons;

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;

class ZondiconFactory
{
    private $config = [
        'inline' => false,
        'class' => 'zondicon'
    ];

    private $svgCache;
    private $files;

    public function __construct($config = [], $filesystem = null)
    {
        $this->config = array_merge($this->config, $config);
        $this->svgCache = Collection::make();
        $this->files = $filesystem ?: new Filesystem;
    }

    public function icon($name, $class = '')
    {
        return new Zondicon($name, $this->config, $this, $class);
    }

    public function getSvg($name)
    {
        return $this->svgCache->get($name, function () use ($name) {
            return $this->svgCache[$name] = $this->files->get(sprintf('%s/../resources/icons/%s.svg', __DIR__, $name));
        });
    }
}

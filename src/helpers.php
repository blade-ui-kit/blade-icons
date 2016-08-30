<?php

use BladeSvg\IconFactory;

if (! function_exists('svg_spritesheet')) {
    function svg_spritesheet()
    {
        return app(IconFactory::class)->spritesheet();
    }
}

if (! function_exists('svg_icon')) {
    function svg_icon($icon, $class = '', $attrs = [])
    {
        return app(IconFactory::class)->icon($icon, $class, $attrs);
    }
}

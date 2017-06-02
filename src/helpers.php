<?php

use BladeSvg\SvgFactory;

if (! function_exists('svg_spritesheet')) {
    function svg_spritesheet()
    {
        return app(SvgFactory::class)->spritesheet();
    }
}

if (! function_exists('svg_image')) {
    function svg_image($icon, $class = '', $attrs = [])
    {
        return app(SvgFactory::class)->svg($icon, $class, $attrs);
    }
}

if (! function_exists('svg_icon')) {
    /**
     * @deprecated  Use `svg_image`
     */
    function svg_icon($icon, $class = '', $attrs = [])
    {
        return app(SvgFactory::class)->svg($icon, $class, $attrs);
    }
}

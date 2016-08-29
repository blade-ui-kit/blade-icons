<?php

use Zondicons\ZondiconFactory;
use Illuminate\Support\HtmlString;

if (! function_exists('zondicons')) {
    function zondicons()
    {
        return new HtmlString(
            sprintf('<div style="display: none;">%s</div>', file_get_contents(__DIR__ . '/../resources/sprite.svg'))
        );
    }
}

if (! function_exists('zondicon')) {
    function zondicon($icon, $class = '')
    {
        return app(ZondiconFactory::class)->icon($icon, $class);
    }
}

<?php

declare(strict_types=1);

use BladeUI\Icons\Factory;
use BladeUI\Icons\Svg;
use BladeUI\Icons\Sprite;
use BladeUI\Icons\SpriteSheet;

if (! function_exists('svg')) {
    function svg(string $name, $class = '', array $attributes = []): Svg
    {
        return app(Factory::class)->svg($name, $class, $attributes);
    }
}

if (! function_exists('sprite')) {
    function sprite(string $set, $class = '', array $attributes = []): Sprite
    {
        return app(Factory::class)->sprite($set, $class, $attributes);
    }
}

if (! function_exists('sprite_sheet')) {
    function sprite_sheet(string $set = 'default'): SpriteSheet
    {
        return app(Factory::class)->spriteSheet($set);
    }
}

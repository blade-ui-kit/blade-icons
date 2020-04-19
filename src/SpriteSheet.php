<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use Illuminate\Contracts\Support\Htmlable;

final class SpriteSheet implements Htmlable
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function toHtml(): string
    {
        return sprintf(
            '<div style="height: 0; width: 0; position: absolute; visibility: hidden;">%s</div>',
            file_get_contents($this->path)
        );
    }
}

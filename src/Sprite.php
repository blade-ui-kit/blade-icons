<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Concerns\RendersAttributes;
use Illuminate\Contracts\Support\Htmlable;

final class Sprite implements Htmlable
{
    use RendersAttributes;

    /** @var string */
    private $name;

    /** @var string */
    private $url;

    /** @var string */
    private $prefix;

    public function __construct(string $name, string $url, array $attributes = [], string $prefix = '')
    {
        $this->name = $name;
        $this->url = $url;
        $this->attributes = $attributes;
        $this->prefix = $prefix;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function prefix(): string
    {
        return $this->prefix;
    }

    public function toHtml(): string
    {
        return vsprintf('<svg%s><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="%s#%s"></use></svg>', [
            $this->renderAttributes(),
            $this->url,
            $this->id()
        ]);
    }

    public function id(): string
    {
        if ($this->prefix) {
            return "{$this->prefix}-{$this->name}";
        }

        return $this->name;
    }
}

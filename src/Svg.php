<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Concerns\RendersAttributes;
use Illuminate\Contracts\Support\Htmlable;

final class Svg implements Htmlable
{
    use RendersAttributes;

    /** @var string */
    private $name;

    /** @var string */
    private $contents;

    public function __construct(string $name, string $contents, array $attributes = [])
    {
        $this->name = $name;
        $this->contents = $contents;
        $this->attributes = $attributes;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function contents(): string
    {
        return $this->contents;
    }

    public function toHtml(): string
    {
        return str_replace(
            '<svg',
            sprintf('<svg%s', $this->renderAttributes()),
            $this->contents,
        );
    }
}

<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Concerns\RendersAttributes;
use Illuminate\Contracts\Support\Htmlable;

final class Svg implements Htmlable
{
    use RendersAttributes;

    private string $name;

    private string $contents;

    public function __construct(string $name, string $contents, array $attributes = [])
    {
        $this->name = $name;
        $this->contents = $this->deferContent($contents, $attributes['defer'] ?? false);
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

    protected function deferContent($contents, $defer = false)
    {
        if (! $defer) {
            return $contents;
        }

        $svgContent = strip_tags($contents, ['circle', 'ellipse', 'line', 'path', 'polygon', 'polyline', 'rect']);
        $hash = 'icon-'.md5($svgContent);
        $contents = str_replace($svgContent, strtr('<use href=":href"></use>', [':href' => '#'.$hash]), $contents);
        $contents .= <<<BLADE

                @once("{$hash}")
                    @push("bladeicons")
                        <g id="{$hash}">
                            {$svgContent}
                        </g>
                    @endpush
                @endonce
            BLADE;

        return $contents;
    }
}

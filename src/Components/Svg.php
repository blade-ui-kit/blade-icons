<?php

declare(strict_types=1);

namespace BladeUI\Icons\Components;

use BladeUI\Icons\Factory;
use Illuminate\Support\Str;
use Illuminate\View\Component;

final class Svg extends Component
{
    /** @var Factory */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function render(): string
    {
        $attributes = $this->attributes ? $this->attributes->toHtml() : '';

        $prefix = Str::before($this->componentName, '-');

        $set = collect($this->factory->all())->where('component-prefix', $prefix)->keys()->first();

        $icon = Str::after($this->componentName, '-');

        return str_replace(
            '<svg',
            sprintf('<svg%s', ($attributes !== '' ? ' ' : '') . $attributes),
            svg("$set:$icon")->toHtml()
        );
    }
}

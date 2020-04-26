<?php

declare(strict_types=1);

namespace BladeUI\Icons\Components;

use BladeUI\Icons\Factory;
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

        return str_replace(
            '<svg',
            sprintf('<svg%s', ($attributes !== '' ? ' ' : '') . $attributes),
            svg($this->componentName)->toHtml()
        );
    }
}

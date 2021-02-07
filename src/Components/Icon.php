<?php

declare(strict_types=1);

namespace BladeUI\Icons\Components;

use Illuminate\View\Component;

final class Icon extends Component
{
    /** @var string */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return function (array $data) {
            $attributes = $data['attributes']->getIterator()->getArrayCopy();

            $class = $attributes['class'] ?? '';

            unset($attributes['class']);

            return svg($this->name, $class, $attributes)->toHtml();
        };
    }
}

<?php

declare(strict_types=1);

namespace BladeUI\Icons\Components;

use Illuminate\View\Component;

final class Svg extends Component
{
    public function render()
    {
        return function (array $data) {
            return svg($this->componentName, $data['attributes']->getIterator()->getArrayCopy())->toHtml();
        };
    }
}

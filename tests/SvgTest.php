<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Svg;
use PHPUnit\Framework\TestCase;

class SvgTest extends TestCase
{
    /** @test */
    public function it_can_return_its_name()
    {
        $svg = new Svg('heroicon-s-camera', '<svg></svg>');

        $this->assertSame('heroicon-s-camera', $svg->name());
    }

    /** @test */
    public function it_can_compile_to_html()
    {
        $svg = new Svg('heroicon-s-camera', '<svg></svg>');

        $this->assertSame('<svg></svg>', $svg->toHtml());
    }

    /** @test */
    public function it_can_compile_with_attributes()
    {
        $svg = new Svg('heroicon-s-camera', '<svg></svg>', ['class' => 'icon', 'style' => 'color: #fff', 'data-foo']);

        $this->assertSame('<svg class="icon" style="color: #fff" data-foo></svg>', $svg->toHtml());
    }

    /** @test */
    public function it_can_pass_in_attributes_fluently()
    {
        $svg = new Svg('heroicon-s-camera', '<svg></svg>');

        $svg->class('icon')->style('color: #fff')->dataFoo();

        $this->assertSame('<svg class="icon" style="color: #fff" data-foo></svg>', $svg->toHtml());
    }
}

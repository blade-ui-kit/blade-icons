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
    public function it_can_compile_to_defered_html()
    {
        $svgPath = '<path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();
        $this->assertEquals('<svg defer="1"><use href="#icon-8970cc32a6db8f9088d764a8832c411b"></use></svg>
    @once("icon-8970cc32a6db8f9088d764a8832c411b")
        @push("bladeicons")
            <g id="icon-8970cc32a6db8f9088d764a8832c411b">
                <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_custom_defer()
    {
        $svgPath = '<path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => 'my-custom-hash']);

        $svgHtml = $svg->toHtml();
        $this->assertEquals('<svg defer="my-custom-hash"><use href="#icon-my-custom-hash"></use></svg>
    @once("icon-my-custom-hash")
        @push("bladeicons")
            <g id="icon-my-custom-hash">
                <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_with_group()
    {
        $svgPath = '<g id="test" transform="translate(1 1)"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></g>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg defer="1"><use href="#icon-17c27df6b7d6560d9202829b719225b0"></use></svg>
    @once("icon-17c27df6b7d6560d9202829b719225b0")
        @push("bladeicons")
            <g id="icon-17c27df6b7d6560d9202829b719225b0">
                <g id="test" transform="translate(1 1)"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></g>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_with_group_custom_defer()
    {
        $svgPath = '<g id="test" transform="translate(1 1)"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></g>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => 'my-custom-hash']);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg defer="my-custom-hash"><use href="#icon-my-custom-hash"></use></svg>
    @once("icon-my-custom-hash")
        @push("bladeicons")
            <g id="icon-my-custom-hash">
                <g id="test" transform="translate(1 1)"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></g>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_with_group_and_whitespace()
    {
        $svgPath = '
<g id="test" transform="translate(1 1)">
    <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</g>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg defer="1"><use href="#icon-e691490d4580d7276ba2a39a287f365f"></use></svg>
    @once("icon-e691490d4580d7276ba2a39a287f365f")
        @push("bladeicons")
            <g id="icon-e691490d4580d7276ba2a39a287f365f">
                
<g id="test" transform="translate(1 1)">
    <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</g>
            </g>
        @endpush
    @endonce', $svgHtml);
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

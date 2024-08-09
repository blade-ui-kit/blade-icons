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
        $this->assertEquals('<svg><use href="#icon-8970cc32a6db8f9088d764a8832c411b"></use></svg>
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
        $this->assertEquals('<svg><use href="#icon-my-custom-hash"></use></svg>
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

        $this->assertEquals('<svg><use href="#icon-17c27df6b7d6560d9202829b719225b0"></use></svg>
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

        $this->assertEquals('<svg><use href="#icon-my-custom-hash"></use></svg>
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
        $svgPath = '<g id="test" transform="translate(1 1)">
    <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</g>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg><use href="#icon-7f6f192a3c61bd15e25530394ec18d86"></use></svg>
    @once("icon-7f6f192a3c61bd15e25530394ec18d86")
        @push("bladeicons")
            <g id="icon-7f6f192a3c61bd15e25530394ec18d86">
                <g id="test" transform="translate(1 1)">
    <path d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
</g>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_with_mask_tag()
    {
        $svgPath = '<mask id="test" fill="#fff">
    <path d="M0 30c0 16.56 13.44 30 30 30 16.56 0 30-13.44 30-30C60 13.44 46.56 0 30 0 13.44 0 0 13.44 0 30Zm4.35 0C4.35 15.84 15.845 4.35 30 4.35c6.295 0 12.08 2.27 16.495 6.04l-29.87 29.93-6.165 6.17C6.625 42.075 4.35 36.3 4.35 30Zm45.26-16.555c3.77 4.475 6.04 10.26 6.04 16.49 0 14.22-11.49 25.715-25.65 25.715-6.3 0-12.08-2.275-16.49-6.04l5.905-5.91-.005-.005 30.2-30.25Z" />
</mask>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg><use href="#icon-75e079eb3e6f7403d66f76ff7f0475c5"></use></svg>
    @once("icon-75e079eb3e6f7403d66f76ff7f0475c5")
        @push("bladeicons")
            <g id="icon-75e079eb3e6f7403d66f76ff7f0475c5">
                <mask id="test" fill="#fff">
    <path d="M0 30c0 16.56 13.44 30 30 30 16.56 0 30-13.44 30-30C60 13.44 46.56 0 30 0 13.44 0 0 13.44 0 30Zm4.35 0C4.35 15.84 15.845 4.35 30 4.35c6.295 0 12.08 2.27 16.495 6.04l-29.87 29.93-6.165 6.17C6.625 42.075 4.35 36.3 4.35 30Zm45.26-16.555c3.77 4.475 6.04 10.26 6.04 16.49 0 14.22-11.49 25.715-25.65 25.715-6.3 0-12.08-2.275-16.49-6.04l5.905-5.91-.005-.005 30.2-30.25Z" />
</mask>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_with_defs_tag()
    {
        $svgPath = '<defs>
    <path d="M0 29.997495C0 46.567015 13.427975 60 30.002505 60 46.567015 60 60 46.567015 60 29.997495 60 13.432985 46.567015 0 30.002505 0 13.427975 0 0 13.432985 0 29.997495Z" id="fodmap-a"/>
    <path d="M15.685498 3.670797C2.64507 10.886334-3.260408 26.270404 1.80359 40.303137c3.280262 9.091274 9.639234 15.2328 18.784665 18.459875.408143.141184.745743.226903 1.022877.236988h.100776c.665122-.025211.92714-.529442.891869-1.699256-.105815-3.101018.146125-6.222204-.095738-9.303052-.403104-5.0776 3.824453-8.718143 8.591162-8.460986 3.900035.206735 7.825264.095804 11.730338.005043 2.7008-.060508 4.252751-1.724468 4.167092-4.175028-.08566-2.279122-1.72831-3.711136-4.378722-3.731305-4.04616-.02017-8.09232 0-12.13848 0-1.360478 0-2.715916.010084-4.076394.025211-2.957778.030254-5.920595.060508-8.868296-.070592-5.376405-.226904-8.581085-5.985215-6.177575-10.760277 1.451176-2.899325 3.814376-4.255705 6.978745-4.301085 4.111665-.060508 8.228368-.050423 12.334994-.141185 3.174447-.070592 4.51477-1.482437 4.539963-4.659089.020155-3.232117-.04031-6.474318.025194-9.711477.025194-1.321084-.569385-1.81523-1.76862-1.905991C32.479834.040338 31.492228 0 30.5147 0c-5.189969 0-10.168308 1.09418-14.829202 3.670797Z" id="fodmap-c"/>
    <path d="M24.539044 1.93889c-.005033 2.724387.005033 5.453746.0151 8.178134.0151 5.210143-3.110582 8.25768-8.44085 8.247736-3.840411-.009943-7.680822-.019886-11.5162.009943-2.81865.019886-4.660839 1.635627-4.595406 3.942408.0604 2.306781 1.726423 3.738576 4.535007 3.763434 4.107176.044743 8.214352.009943 12.321528.009943v-.034801h5.657433c1.952922.004971 3.905844.014915 5.863799.019886 4.721239.004972 8.179119 3.19171 8.158985 7.521896-.025166 4.330185-3.462913 7.482123-8.199252 7.511952-3.905843.019886-7.811687.014915-11.71753.059658-3.437747.039772-4.711173 1.332365-4.731306 4.757736-.020134 3.19171.130866 6.388391-.0604 9.57513-.115766 1.90906.649296 2.366438 2.370686 2.455925 14.13855.750699 27.230174-8.605684 30.80382-22.093393C48.905267 21.163721 41.03318 5.861411 26.809063.477265 26.02387.178975 25.510472 0 25.178274 0c-.583864 0-.634197.541895-.63923 1.93889Z" id="fodmap-e"/>
</defs>';
        $svg = new Svg('heroicon-o-arrow-right', '<svg>'.$svgPath.'</svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg><use href="#icon-cf7005271ce6acebfa1a20cb123ad8b0"></use></svg>
    @once("icon-cf7005271ce6acebfa1a20cb123ad8b0")
        @push("bladeicons")
            <g id="icon-cf7005271ce6acebfa1a20cb123ad8b0">
                <defs>
    <path d="M0 29.997495C0 46.567015 13.427975 60 30.002505 60 46.567015 60 60 46.567015 60 29.997495 60 13.432985 46.567015 0 30.002505 0 13.427975 0 0 13.432985 0 29.997495Z" id="fodmap-a"/>
    <path d="M15.685498 3.670797C2.64507 10.886334-3.260408 26.270404 1.80359 40.303137c3.280262 9.091274 9.639234 15.2328 18.784665 18.459875.408143.141184.745743.226903 1.022877.236988h.100776c.665122-.025211.92714-.529442.891869-1.699256-.105815-3.101018.146125-6.222204-.095738-9.303052-.403104-5.0776 3.824453-8.718143 8.591162-8.460986 3.900035.206735 7.825264.095804 11.730338.005043 2.7008-.060508 4.252751-1.724468 4.167092-4.175028-.08566-2.279122-1.72831-3.711136-4.378722-3.731305-4.04616-.02017-8.09232 0-12.13848 0-1.360478 0-2.715916.010084-4.076394.025211-2.957778.030254-5.920595.060508-8.868296-.070592-5.376405-.226904-8.581085-5.985215-6.177575-10.760277 1.451176-2.899325 3.814376-4.255705 6.978745-4.301085 4.111665-.060508 8.228368-.050423 12.334994-.141185 3.174447-.070592 4.51477-1.482437 4.539963-4.659089.020155-3.232117-.04031-6.474318.025194-9.711477.025194-1.321084-.569385-1.81523-1.76862-1.905991C32.479834.040338 31.492228 0 30.5147 0c-5.189969 0-10.168308 1.09418-14.829202 3.670797Z" id="fodmap-c"/>
    <path d="M24.539044 1.93889c-.005033 2.724387.005033 5.453746.0151 8.178134.0151 5.210143-3.110582 8.25768-8.44085 8.247736-3.840411-.009943-7.680822-.019886-11.5162.009943-2.81865.019886-4.660839 1.635627-4.595406 3.942408.0604 2.306781 1.726423 3.738576 4.535007 3.763434 4.107176.044743 8.214352.009943 12.321528.009943v-.034801h5.657433c1.952922.004971 3.905844.014915 5.863799.019886 4.721239.004972 8.179119 3.19171 8.158985 7.521896-.025166 4.330185-3.462913 7.482123-8.199252 7.511952-3.905843.019886-7.811687.014915-11.71753.059658-3.437747.039772-4.711173 1.332365-4.731306 4.757736-.020134 3.19171.130866 6.388391-.0604 9.57513-.115766 1.90906.649296 2.366438 2.370686 2.455925 14.13855.750699 27.230174-8.605684 30.80382-22.093393C48.905267 21.163721 41.03318 5.861411 26.809063.477265 26.02387.178975 25.510472 0 25.178274 0c-.583864 0-.634197.541895-.63923 1.93889Z" id="fodmap-e"/>
</defs>
            </g>
        @endpush
    @endonce', $svgHtml);
    }

    /** @test */
    public function it_can_compile_to_defered_html_with_use_tag()
    {
        $svg = new Svg('heroicon-o-arrow-right', '<svg><use xlink:href="#fodmap-e"/></svg>', ['defer' => true]);

        $svgHtml = $svg->toHtml();

        $this->assertEquals('<svg><use href="#icon-540a77d3751047fd94004bffda3ffb55"></use></svg>
    @once("icon-540a77d3751047fd94004bffda3ffb55")
        @push("bladeicons")
            <g id="icon-540a77d3751047fd94004bffda3ffb55">
                <use xlink:href="#fodmap-e"/>
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

    /** @test */
    public function it_can_add_title_tag_if_title_attribute_is_passed()
    {
        $svg = new Svg('heroicon-s-camera', '<svg></svg>', ['title' => 'Camera']);

        $this->assertStringContainsString('><title', $svg->toHtml());
        $this->assertStringContainsString('</title></svg>', $svg->toHtml());
    }

    /** @test */
    public function it_can_add_aria_labelledby_and_role_attributes_if_title_attribute_is_passed()
    {
        $svg = new Svg('heroicon-s-camera', '<svg></svg>', ['title' => 'Camera']);

        $this->assertStringContainsString('role="img">', $svg->toHtml());
    }
}

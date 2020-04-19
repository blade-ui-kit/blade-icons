<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Sprite;
use PHPUnit\Framework\TestCase;

class SpriteTest extends TestCase
{
    /** @test */
    public function it_can_return_its_name()
    {
        $sprite = new Sprite('heroicon-s-camera', 'http://example.com/icons.svg');

        $this->assertSame('heroicon-s-camera', $sprite->name());
    }

    /** @test */
    public function it_can_compile_to_html()
    {
        $sprite = new Sprite('heroicon-s-camera', 'http://example.com/icons.svg');

        $expected = <<<HTML
<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://example.com/icons.svg#heroicon-s-camera"></use></svg>
HTML;

        $this->assertSame($expected, $sprite->toHtml());
    }

    /** @test */
    public function it_can_compile_with_attributes()
    {
        $sprite = new Sprite('heroicon-s-camera', 'http://example.com/icons.svg', ['class' => 'icon', 'style' => 'color: #fff', 'data-foo']);

        $expected = <<<HTML
<svg class="icon" style="color: #fff" data-foo><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://example.com/icons.svg#heroicon-s-camera"></use></svg>
HTML;

        $this->assertSame($expected, $sprite->toHtml());
    }

    /** @test */
    public function it_can_pass_in_attributes_fluently()
    {
        $sprite = new Sprite('heroicon-s-camera', 'http://example.com/icons.svg');

        $sprite->class('icon')->style('color: #fff')->dataFoo();

        $expected = <<<HTML
<svg class="icon" style="color: #fff" data-foo><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://example.com/icons.svg#heroicon-s-camera"></use></svg>
HTML;

        $this->assertSame($expected, $sprite->toHtml());
    }

    /** @test */
    public function it_can_set_a_prefix_for_its_id()
    {
        $sprite = new Sprite('heroicon-s-camera', 'http://example.com/icons.svg', [], 'solid');

        $expected = <<<HTML
<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://example.com/icons.svg#solid-heroicon-s-camera"></use></svg>
HTML;

        $this->assertSame($expected, $sprite->toHtml());
    }
}

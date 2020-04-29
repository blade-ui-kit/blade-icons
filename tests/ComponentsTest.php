<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Components\Svg;
use Illuminate\Support\Facades\Blade;

class ComponentsTest extends TestCase
{
    /** @test */
    public function components_are_registered_with_their_subdirectories()
    {
        $this->prepareSets();

        $this->assertSame([
            'icon-camera' => Svg::class,
            'icon-prefixed-camera' => Svg::class,
            'icon-solid.camera' => Svg::class,
            'zondicon-flag' => Svg::class,
        ], Blade::getClassComponentAliases());
    }

    /** @test */
    public function it_can_render_an_icon()
    {
        $factory = $this->prepareSets();

        $component = (new Svg($factory))->withName('icon-camera')->withAttributes([]);

        $expected = <<<HTML
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>
HTML;

        $this->assertSame($expected, $component->render());
    }

    /** @test */
    public function it_can_render_an_icon_without_setting_attributes()
    {
        $factory = $this->prepareSets();

        $component = (new Svg($factory))->withName('icon-camera');

        $expected = <<<HTML
<svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>
HTML;

        $this->assertSame($expected, $component->render());
    }

    /** @test */
    public function it_can_render_an_icon_from_a_subdirectory()
    {
        $factory = $this->prepareSets();

        $component = (new Svg($factory))->withName('icon-solid.camera')->withAttributes([]);

        $expected = <<<HTML
<svg viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
</svg>
HTML;

        $this->assertSame($expected, $component->render());
    }

    /** @test */
    public function it_can_render_an_icon_from_a_specific_set()
    {
        $factory = $this->prepareSets();

        $component = (new Svg($factory))->withName('zondicon-flag')->withAttributes([]);

        $expected = <<<HTML
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/></svg>
HTML;

        $this->assertSame($expected, $component->render());
    }

    /** @test */
    public function it_can_render_an_icons_in_subdirectories()
    {
        $factory = $this->prepareSets();

        $component = (new Svg($factory))->withName('icon-solid.camera')->withAttributes([]);

        $expected = <<<HTML
<svg viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
</svg>
HTML;

        $this->assertSame($expected, $component->render());
    }

    /** @test */
    public function it_can_render_attributes()
    {
        $factory = $this->prepareSets();

        $component = (new Svg($factory))->withName('icon-camera')->withAttributes(['class' => 'icon icon-lg', 'data-foo' => true]);

        $expected = <<<HTML
<svg class="icon icon-lg" data-foo="data-foo" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>
HTML;

        $this->assertSame($expected, $component->render());
    }
}

<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Components\Svg;
use Illuminate\Support\Facades\Blade;
use InvalidArgumentException;

class ComponentsTest extends TestCase
{
    /** @test */
    public function components_are_registered_with_their_subdirectories()
    {
        $this->prepareSets()->registerComponents();

        $compiled = Blade::getClassComponentAliases();

        $expected = [
            'icon-camera' => Svg::class,
            'icon-foo-camera' => Svg::class,
            'icon-solid.camera' => Svg::class,
            'icon-zondicon-flag' => Svg::class,
            'zondicon-flag' => Svg::class,
        ];

        foreach ($expected as $alias => $component) {
            $this->assertArrayHasKey($alias, $compiled);
            $this->assertSame(Svg::class, $component);
        }
    }

    /** @test */
    public function components_are_not_registered_when_disabled()
    {
        $this->prepareSets(['components' => ['disabled' => true]])->registerComponents();

        $compiled = Blade::getClassComponentAliases();

        $this->assertNotContains(Svg::class, $compiled);
    }

    /** @test */
    public function it_can_render_an_icon()
    {
        $this->prepareSets();

        $view = $this->blade('<x-icon-camera/>');

        $expected = <<<'HTML'
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_with_default_classes()
    {
        $this->prepareSets([], ['default' => ['class' => 'w-6 h-6']]);

        $view = $this->blade('<x-icon-camera/>');

        $expected = <<<'HTML'
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_with_default_classes_and_set_classes()
    {
        $this->prepareSets(['class' => 'text-blue-500'], ['default' => ['class' => 'w-6 h-6']]);

        $view = $this->blade('<x-icon-camera class="icon icon-lg" data-foo/>');

        $expected = <<<'HTML'
            <svg data-foo="1" class="text-blue-500 w-6 h-6 icon icon-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_with_default_attributes()
    {
        $this->prepareSets(['attributes' => ['width' => 50, 'height' => 50]]);

        $view = $this->blade('<x-icon-camera/>');

        $expected = <<<'HTML'
            <svg width="50" height="50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_with_default_attributes_and_set_attributes()
    {
        $this->prepareSets(['attributes' => ['width' => 50]], ['default' => ['attributes' => ['height' => 50]]]);

        $view = $this->blade('<x-icon-camera/>');

        $expected = <<<'HTML'
            <svg width="50" height="50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_does_not_duplicate_attributes()
    {
        $this->prepareSets(['attributes' => ['height' => 50]], ['default' => ['attributes' => ['height' => 50]]]);

        $view = $this->blade('<x-icon-camera/>');

        $expected = <<<'HTML'
            <svg height="50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_prioritizes_default_and_set_classes_on_components()
    {
        $this->prepareSets(['class' => 'h-40'], ['default' => ['class' => 'h-50']]);

        $view = $this->blade('<x-icon-camera class="h-30"/>');

        $expected = <<<'HTML'
            <svg class="h-40 h-50 h-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_prioritizes_attributes_on_components()
    {
        $this->prepareSets(['attributes' => ['height' => 40]], ['default' => ['attributes' => ['height' => 50]]]);

        $view = $this->blade('<x-icon-camera height="60"/>');

        $expected = <<<'HTML'
            <svg height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_from_a_subdirectory()
    {
        $this->prepareSets();

        $view = $this->blade('<x-icon-solid.camera/>');

        $expected = <<<'HTML'
            <svg viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_from_a_specific_set()
    {
        $this->prepareSets();

        $view = $this->blade('<x-zondicon-flag/>');

        $expected = <<<'HTML'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/></svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_attributes()
    {
        $this->prepareSets();

        $view = $this->blade('<x-icon-camera class="icon icon-lg" data-foo/>');

        $expected = <<<'HTML'
            <svg data-foo="1" class="icon icon-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_with_the_icon_component()
    {
        $this->prepareSets();

        $view = $this->blade('<x-icon name="camera" class="icon icon-lg" data-foo/>');

        $expected = <<<'HTML'
            <svg data-foo="1" class="icon icon-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_from_a_specific_set_with_the_icon_component()
    {
        $this->prepareSets();

        $view = $this->blade('<x-icon name="zondicon-flag"/>');

        $expected = <<<'HTML'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/></svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_can_render_an_icon_when_multiple_paths_are_defined()
    {
        $factory = $this->prepareSets();

        $factory->add('mixed', [
            'paths' => [
                __DIR__.'/resources/svg/',
                __DIR__.'/resources/zondicons/',
            ],
            'prefix' => 'mixed',
        ]);

        $view = $this->blade('<x-mixed-camera/>');

        $expected = <<<'HTML'
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            HTML;

        $view->assertSee($expected, false);

        $view = $this->blade('<x-mixed-flag/>');

        $expected = <<<'HTML'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/></svg>
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_strips_the_xml_tag_if_resent()
    {
        $this->prepareSets();

        $view = $this->blade('<x-icon-xml/>');

        $expected = <<<'HTML'
            <!-- Generator: Adobe Illustrator 24.3.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 665 638" style="enable-background:new 0 0 665 638;" xml:space="preserve">
            HTML;

        $view->assertSee($expected, false);
    }

    /** @test */
    public function it_files_without_an_svg_extension_are_not_registered()
    {
        $this->prepareSets();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to locate a class or view for component [icon-invalid-extension].');

        $this->blade('<x-icon-invalid-extension/>');
    }
}

<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Exceptions\SvgNotFound;
use BladeUI\Icons\Factory;
use BladeUI\Icons\IconsManifest;
use BladeUI\Icons\Svg;
use Illuminate\Filesystem\Filesystem;
use Mockery;

class FactoryTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    /** @test */
    public function it_can_add_a_set()
    {
        $factory = $this->prepareSets();

        $sets = $factory->all();

        $this->assertCount(2, $sets);
    }

    /** @test */
    public function it_can_retrieve_an_icon()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('camera');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('camera', $icon->name());
    }

    /** @test */
    public function it_can_retrieve_an_icon_with_default_prefix()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('icon-camera');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('camera', $icon->name());
    }

    /** @test */
    public function it_can_retrieve_an_icon_with_a_dash()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('foo-camera');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('foo-camera', $icon->name());
    }

    /** @test */
    public function it_can_retrieve_an_icon_from_a_specific_set()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('zondicon-flag');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('flag', $icon->name());
    }

    /** @test */
    public function icons_from_sets_other_than_default_are_retrieved_first()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('zondicon-flag');

        $expected = <<<'HTML'
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/></svg>
            HTML;

        $this->assertSame($expected, $icon->contents());
    }

    /** @test */
    public function icons_are_cached()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('missing')->andReturn(false);
        $filesystem->shouldReceive('get')
            ->once()
            ->with('/default/svg/camera.svg')
            ->andReturn($defaultIcon = '<svg>Foo</svg>');
        $filesystem->shouldReceive('get')
            ->once()
            ->with('/heroicon/svg/camera.svg')
            ->andReturn($heroicon = '<svg>Bar</svg>');

        $factory = new Factory($filesystem, $this->app->make(IconsManifest::class));

        $factory->add('default', [
            'path' => '/default/svg',
            'prefix' => 'default',
        ]);
        $factory->add('heroicon', [
            'path' => '/heroicon/svg',
            'prefix' => 'heroicon',
        ]);

        $this->assertSame($defaultIcon, $factory->svg('camera')->contents());
        $this->assertSame($defaultIcon, $factory->svg('camera')->contents());
        $this->assertSame($heroicon, $factory->svg('heroicon-camera')->contents());
        $this->assertSame($heroicon, $factory->svg('heroicon-camera')->contents());
    }

    /** @test */
    public function default_icon_set_is_optional()
    {
        $factory = new Factory(
            new Filesystem(),
            $this->app->make(IconsManifest::class),
            null,
            ['class' => 'icon icon-default'],
        );

        $factory->add('zondicons', [
            'path' => __DIR__.'/resources/zondicons',
            'prefix' => 'zondicon',
            'class' => 'zondicon-class',
        ]);

        $icon = $factory->svg('zondicon-flag');

        $this->assertSame('icon icon-default zondicon-class', $icon->attributes()['class']);
    }

    /** @test */
    public function icon_not_found_without_default_set_throws_proper_exception()
    {
        $factory = new Factory(
            new Filesystem(),
            $this->app->make(IconsManifest::class),
            null,
            ['class' => 'icon icon-default'],
        );

        $factory->add('zondicons', [
            'path' => __DIR__.'/resources/zondicons',
            'prefix' => 'zondicon',
            'class' => 'zondicon-class',
        ]);

        $this->expectExceptionObject(new SvgNotFound(
            'Svg by name "foo" from set "zondicons" not found.',
        ));

        $factory->svg('zondicon-foo');
    }

    /** @test */
    public function icons_can_have_default_classes()
    {
        $factory = $this->prepareSets(['class' => 'icon icon-default']);

        $icon = $factory->svg('camera', 'custom-class');

        $this->assertSame('icon icon-default custom-class', $icon->attributes()['class']);
    }

    /** @test */
    public function default_classes_are_always_applied()
    {
        $factory = $this->prepareSets(['class' => 'icon icon-default']);

        $icon = $factory->svg('camera');

        $this->assertSame('icon icon-default', $icon->attributes()['class']);
    }

    /** @test */
    public function icons_can_have_default_classes_from_sets()
    {
        $factory = $this->prepareSets(['class' => 'icon icon-default'], ['zondicons' => ['class' => 'zondicon-class']]);

        $icon = $factory->svg('camera');

        $this->assertSame('icon icon-default', $icon->attributes()['class']);

        $icon = $factory->svg('zondicon-flag');

        $this->assertSame('icon icon-default zondicon-class', $icon->attributes()['class']);
    }

    /** @test */
    public function default_classes_from_sets_are_applied_even_when_main_default_class_is_empty()
    {
        $factory = $this->prepareSets([], ['zondicons' => ['class' => 'zondicon-class']]);

        $icon = $factory->svg('camera');

        $this->assertArrayNotHasKey('class', $icon->attributes());

        $icon = $factory->svg('zondicon-flag');

        $this->assertSame('zondicon-class', $icon->attributes()['class']);
    }

    /** @test */
    public function passing_classes_as_attributes_will_override_default_classes()
    {
        $factory = $this->prepareSets(['class' => 'icon icon-default']);

        $icon = $factory->svg('camera', '', ['class' => 'custom-class']);

        $this->assertSame('custom-class', $icon->attributes()['class']);

        $icon = $factory->svg('camera', ['class' => 'custom-class']);

        $this->assertSame('custom-class', $icon->attributes()['class']);
    }

    /** @test */
    public function classes_with_xss_are_escaped()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('camera', 'h-4 w-4\" onLoad=\"alert(\'XSS\')');

        $this->assertSame('h-4 w-4\&quot; onLoad=\&quot;alert(\'XSS\')', $icon->attributes()['class']);

        $icon = $factory->svg('camera', '', ['class' => 'h-4 w-4\" onLoad=\"alert(\'XSS\')']);

        $this->assertSame('h-4 w-4\&quot; onLoad=\&quot;alert(\'XSS\')', $icon->attributes()['class']);

        $icon = $factory->svg('camera', '', ['foo' => 'h-4 w-4\" onLoad=\"alert(\'XSS\')']);

        $this->assertSame('h-4 w-4\&quot; onLoad=\&quot;alert(\'XSS\')', $icon->attributes()['foo']);

        $factory = $this->prepareSets(['class' => 'h-4 w-4\" onLoad=\"alert(\'XSS\')']);

        $icon = $factory->svg('camera');

        $this->assertSame('h-4 w-4\&quot; onLoad=\&quot;alert(\'XSS\')', $icon->attributes()['class']);
    }

    /** @test */
    public function icons_can_have_attributes()
    {
        $factory = $this->prepareSets(['class' => 'icon icon-default']);

        $icon = $factory->svg('camera', ['style' => 'color: #fff']);

        $this->assertSame(['style' => 'color: #fff', 'class' => 'icon icon-default'], $icon->attributes());
    }

    /** @test */
    public function it_can_retrieve_an_icon_from_a_subdirectory()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('solid.camera');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('solid.camera', $icon->name());
    }

    /** @test */
    public function it_throws_an_exception_for_files_without_an_svg_extension()
    {
        $factory = $this->prepareSets();

        $this->expectException(SvgNotFound::class);
        $this->expectExceptionMessage('Svg by name "invalid-extension" from set "default" not found.');

        $factory->svg('invalid-extension');
    }

    /** @test */
    public function it_throws_an_exception_when_no_icon_is_found()
    {
        $factory = $this->prepareSets();

        $this->expectException(SvgNotFound::class);
        $this->expectExceptionMessage('Svg by name "money" from set "default" not found.');

        $factory->svg('money');
    }

    /** @test */
    public function it_trims_the_trailing_slash_from_the_path()
    {
        $factory = $this->prepareSets();

        $factory->add('default', [
            'path' => __DIR__.'/resources/svg/',
            'prefix' => '',
        ]);

        $this->assertSame([__DIR__.'/resources/svg'], $factory->all()['default']['paths']);
    }

    /** @test */
    public function it_trims_the_trailing_slash_from_all_paths()
    {
        $factory = $this->prepareSets();

        $factory->add('default', [
            'paths' => [
                __DIR__.'/resources/svg/',
                __DIR__.'/resources/zondicons/',
            ],
            'prefix' => '',
        ]);

        $this->assertSame(__DIR__.'/resources/svg', $factory->all()['default']['paths'][0]);
        $this->assertSame(__DIR__.'/resources/zondicons', $factory->all()['default']['paths'][1]);
    }

    /** @test */
    public function it_uses_the_fallback_icon_from_a_set_when_configured(): void
    {
        $factory = $this->prepareSets([], ['zondicons' => ['fallback' => 'flag']]);

        $icon = $factory->svg('zondicon-non-existing-icon');

        $this->assertSame('flag', $icon->name());
    }

    /** @test */
    public function it_uses_the_fallback_icon_from_the_default_set_when_configured(): void
    {
        $factory = $this->prepareSets([], ['default' => ['fallback' => 'camera']]);

        $icon = $factory->svg('non-existing-icon');

        $this->assertSame('camera', $icon->name());
    }

    /** @test */
    public function it_does_not_use_the_fallback_icon_from_the_default_set_when_a_specific_set_is_targeted(): void
    {
        $factory = $this->prepareSets([], ['default' => ['fallback' => 'camera']]);

        $this->expectException(SvgNotFound::class);

        $factory->svg('zondicon-non-existing-icon');
    }

    /** @test */
    public function it_uses_the_global_fallback_icon_when_configured(): void
    {
        $factory = $this->prepareSets(['fallback' => 'camera']);

        $icon = $factory->svg('zondicon-non-existing-icon');

        $this->assertSame('camera', $icon->name());
    }

    /** @test */
    public function it_can_use_a_specific_set_icon_as_the_global_fallback(): void
    {
        $factory = $this->prepareSets(['fallback' => 'zondicon-flag']);

        $icon = $factory->svg('non-existing-icon');

        $this->assertSame('flag', $icon->name());
    }
}

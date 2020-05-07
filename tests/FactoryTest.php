<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Exceptions\SvgNotFound;
use BladeUI\Icons\Factory;
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

        $expected = <<<HTML
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7.667 12H2v8H0V0h12l.333 2H20l-3 6 3 6H8l-.333-2z"/></svg>
HTML;

        $this->assertSame($expected, $icon->contents());
    }

    /** @test */
    public function icons_are_cached()
    {
        $options = [
            'path' => __DIR__ . '/resources/svg',
            'prefix' => 'icon',
        ];

        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('missing')->andReturn(false);
        $filesystem->shouldReceive('allFiles')->with($options['path'])->andReturn([]);
        $filesystem->shouldReceive('get')->once()->andReturn('<svg></svg>');

        $factory = new Factory($filesystem);

        $factory->add('default', $options);

        $factory->svg('camera');
        $factory->svg('camera');
        $factory->svg('camera');
    }

    /** @test */
    public function icons_can_have_default_classes()
    {
        $factory = $this->prepareSets('icon icon-default');

        $icon = $factory->svg('camera', 'custom-class');

        $this->assertSame('icon icon-default custom-class', $icon->attributes()['class']);
    }

    /** @test */
    public function default_classes_are_always_applied()
    {
        $factory = $this->prepareSets('icon icon-default');

        $icon = $factory->svg('camera');

        $this->assertSame('icon icon-default', $icon->attributes()['class']);
    }

    /** @test */
    public function passing_classes_as_attributes_will_override_default_classes()
    {
        $factory = $this->prepareSets('icon icon-default');

        $icon = $factory->svg('camera', '', ['class' => 'custom-class']);

        $this->assertSame('custom-class', $icon->attributes()['class']);

        $icon = $factory->svg('camera', ['class' => 'custom-class']);

        $this->assertSame('custom-class', $icon->attributes()['class']);
    }

    /** @test */
    public function icons_can_have_attributes()
    {
        $factory = $this->prepareSets('icon icon-default');

        $icon = $factory->svg('camera', ['style' => 'color: #fff']);

        $this->assertSame(['style' => 'color: #fff'], $icon->attributes());
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
    public function it_throws_an_exception_when_no_icon_is_found()
    {
        $factory = $this->prepareSets();

        $this->expectException(SvgNotFound::class);
        $this->expectExceptionMessage('Svg by name "money" from set "default" not found.');

        $factory->svg('money');
    }

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

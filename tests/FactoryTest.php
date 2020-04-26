<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Exceptions\SvgNotFound;
use BladeUI\Icons\Svg;
use BladeUI\Icons\Factory;
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

    /**
     * @test
     * @group Caching
     */
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

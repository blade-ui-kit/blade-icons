<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use BladeUI\Icons\Exceptions\SvgNotFound;
use BladeUI\Icons\Svg;
use BladeUI\Icons\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Mockery;
use Orchestra\Testbench\TestCase;

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
    public function components_are_registered_with_their_subdirectories()
    {
        $this->prepareSets();

        $this->assertSame([
            'icon-camera' => Svg::class,
            'icon-solid.camera' => Svg::class,
            'zondicon-flag' => Svg::class,
        ], Blade::getClassComponentAliases());
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
    public function it_can_retrieve_an_icon_from_a_specific_set()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('zondicons:flag');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('flag', $icon->name());
    }

    /** @test */
    public function it_can_retrieve_an_icon_in_a_subdirectory_from_a_specific_set()
    {
        $factory = $this->prepareSets();

        $icon = $factory->svg('default:solid.camera');

        $this->assertInstanceOf(Svg::class, $icon);
        $this->assertSame('solid.camera', $icon->name());
    }

    /** @test */
    public function icons_are_cached()
    {
        $filesystem = Mockery::spy(Filesystem::class);
        $filesystem->shouldReceive('get')->once()->andReturn('<svg></svg>');

        $factory = new Factory($filesystem);

        $factory->add('default', ['path' => __DIR__ . '/resources/svg']);

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

    private function prepareSets(string $defaultClass = ''): Factory
    {
        $factory = new Factory(new Filesystem(), $defaultClass);

        $factory->add('default', [
            'path' => __DIR__ . '/resources/svg',
            'component-prefix' => 'icon',
        ]);

        $factory->add('zondicons', [
            'path' => __DIR__ . '/resources/zondicons',
            'component-prefix' => 'zondicon',
        ]);

        return $factory;
    }

    protected function getPackageProviders($app): array
    {
        return [BladeIconsServiceProvider::class];
    }
}

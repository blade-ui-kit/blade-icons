<?php

use BladeSvg\IconFactory;
use Illuminate\Filesystem\Filesystem;

class IconFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function can_render_spritesheet()
    {
        $factory = new IconFactory(['spritesheet_path' => __DIR__.'/resources/sprite.svg']);
        $result = $factory->spritesheet();
        $expected = sprintf('<div style="display: none;">%s</div>', file_get_contents(__DIR__.'/resources/sprite.svg'));
        $this->assertEquals($expected, (string) $result);
    }

    /** @test */
    public function icons_are_rendered_from_spritesheet_by_default()
    {
        $factory = new IconFactory(['class' => 'icon']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function icons_are_given_the_icon_class_by_default()
    {
        $factory = new IconFactory();
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_from_spritesheet()
    {
        $factory = new IconFactory(['inline' => false, 'class' => 'icon']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_inline_icon()
    {
        $factory = new IconFactory(['inline' => true, 'class' => 'icon', 'icon_path' => __DIR__.'/resources/icons/']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_with_additional_classes()
    {
        $factory = new IconFactory();
        $result = (string) $factory->icon('arrow-thick-up', 'icon-lg inline-block');
        $expected = '<svg class="icon icon-lg inline-block"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_with_additional_attributes()
    {
        $factory = new IconFactory();
        $result = (string) $factory->icon('arrow-thick-up')->alt('Alt text')->id('arrow-icon');
        $expected = '<svg class="icon" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_inline()
    {
        $factory = new IconFactory(['inline' => false, 'icon_path' => __DIR__.'/resources/icons/']);
        $result = (string) $factory->icon('arrow-thick-up')->inline();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_from_spritesheet()
    {
        $factory = new IconFactory(['inline' => true, 'class' => 'icon']);
        $result = (string) $factory->icon('arrow-thick-up')->sprite();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_specify_an_id_prefix_for_sprited_icons()
    {
        $factory = new IconFactory(['inline' => false, 'class' => 'icon', 'sprite_prefix' => 'icon-']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function inline_icons_are_cached()
    {
        $svgStub = '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $files = Mockery::spy(Filesystem::class, ['get' => $svgStub]);
        $factory = new IconFactory(['inline' => true, 'icon_path' => __DIR__.'/resources/icons/'], $files);

        $resultA = (string) $factory->icon('arrow-thick-up');
        $resultB = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';

        $this->assertEquals($expected, $resultA);
        $this->assertEquals($expected, $resultB);
        $files->shouldHaveReceived('get')->once();
    }
}

<?php

use Zondicons\ZondiconFactory;
use Illuminate\Filesystem\Filesystem;

class ZondiconFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function icons_are_rendered_from_spritesheet_by_default()
    {
        $factory = new ZondiconFactory(['class' => 'zondicon']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="zondicon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function icons_are_given_the_zondicon_class_by_default()
    {
        $factory = new ZondiconFactory();
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="zondicon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_from_spritesheet()
    {
        $factory = new ZondiconFactory(['inline' => false, 'class' => 'zondicon']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="zondicon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_inline_icon()
    {
        $factory = new ZondiconFactory(['inline' => true, 'class' => 'zondicon']);
        $result = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="zondicon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_with_additional_classes()
    {
        $factory = new ZondiconFactory();
        $result = (string) $factory->icon('arrow-thick-up', 'icon-lg inline-block');
        $expected = '<svg class="zondicon icon-lg inline-block"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_with_additional_attributes()
    {
        $factory = new ZondiconFactory();
        $result = (string) $factory->icon('arrow-thick-up')->alt('Alt text')->id('arrow-icon');
        $expected = '<svg class="zondicon" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_inline()
    {
        $factory = new ZondiconFactory(['inline' => false]);
        $result = (string) $factory->icon('arrow-thick-up')->inline();
        $expected = '<svg class="zondicon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_from_spritesheet()
    {
        $factory = new ZondiconFactory(['inline' => true, 'class' => 'zondicon']);
        $result = (string) $factory->icon('arrow-thick-up')->sprite();
        $expected = '<svg class="zondicon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function inline_icons_are_cached()
    {
        $svgStub = '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $files = Mockery::spy(Filesystem::class, ['get' => $svgStub]);
        $factory = new ZondiconFactory(['inline' => true], $files);

        $resultA = (string) $factory->icon('arrow-thick-up');
        $resultB = (string) $factory->icon('arrow-thick-up');
        $expected = '<svg class="zondicon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';

        $this->assertEquals($expected, $resultA);
        $this->assertEquals($expected, $resultB);
        $files->shouldHaveReceived('get')->once();
    }
}

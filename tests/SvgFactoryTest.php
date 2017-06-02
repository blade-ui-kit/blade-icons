<?php

use BladeSvg\SvgFactory;
use Illuminate\Support\HtmlString;
use Illuminate\Filesystem\Filesystem;

class SvgFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function can_render_spritesheet()
    {
        $factory = new SvgFactory(['spritesheet_path' => __DIR__.'/resources/sprite.svg']);
        $result = $factory->spritesheet();
        $expected = sprintf('<div style="height: 0; width: 0; position: absolute; visibility: hidden;">%s</div>', file_get_contents(__DIR__.'/resources/sprite.svg'));
        $this->assertEquals($expected, (string) $result);
    }

    /** @test */
    public function icons_are_rendered_from_spritesheet_by_default()
    {
        $factory = new SvgFactory(['class' => 'icon']);
        $result = $factory->svg('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function icons_are_given_the_icon_class_by_default()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_from_spritesheet()
    {
        $factory = new SvgFactory(['inline' => false, 'class' => 'icon']);
        $result = $factory->svg('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_inline_icon()
    {
        $factory = new SvgFactory(['inline' => true, 'class' => 'icon', 'svg_path' => __DIR__.'/resources/icons/']);
        $result = $factory->svg('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_with_additional_classes()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up', 'icon-lg inline-block')->toHtml();
        $expected = '<svg class="icon icon-lg inline-block"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_specify_additional_attributes_as_an_array()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up', 'icon-lg', ['alt' => 'Alt text', 'id' => 'arrow-icon'])->toHtml();
        $expected = '<svg class="icon icon-lg" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_skip_class_parameter()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up', ['alt' => 'Alt text', 'id' => 'arrow-icon'])->toHtml();
        $expected = '<svg class="icon" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function attributes_without_keys_are_used_as_valueless_html_attributes()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up', ['alt' => 'Alt text', 'data-foo'])->toHtml();
        $expected = '<svg class="icon" alt="Alt text" data-foo><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function specifying_class_as_attribute_overrides_default_class()
    {
        $factory = new SvgFactory(['class' => 'default']);
        $result = $factory->svg('arrow-thick-up', ['class' => 'overridden'])->toHtml();
        $expected = '<svg class="overridden"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_chain_additional_attributes()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up')->alt('Alt text')->id('arrow-icon')->toHtml();
        $expected = '<svg class="icon" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function camelcase_attributes_are_dash_cased_when_chaining()
    {
        $factory = new SvgFactory();
        $result = $factory->svg('arrow-thick-up')->dataFoo('bar')->toHtml();
        $expected = '<svg class="icon" data-foo="bar"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_inline()
    {
        $factory = new SvgFactory(['inline' => false, 'svg_path' => __DIR__.'/resources/icons/']);
        $result = $factory->svg('arrow-thick-up')->inline()->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_from_spritesheet()
    {
        $factory = new SvgFactory(['inline' => true, 'class' => 'icon']);
        $result = $factory->svg('arrow-thick-up')->sprite()->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_specify_an_id_prefix_for_sprited_icons()
    {
        $factory = new SvgFactory(['inline' => false, 'class' => 'icon', 'sprite_prefix' => 'icon-']);
        $result = $factory->svg('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function inline_icons_are_cached()
    {
        $svgStub = '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $files = Mockery::spy(Filesystem::class, ['get' => $svgStub]);
        $factory = new SvgFactory(['inline' => true, 'svg_path' => __DIR__.'/resources/icons/'], $files);

        $resultA = $factory->svg('arrow-thick-up')->toHtml();
        $resultB = $factory->svg('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';

        $this->assertEquals($expected, $resultA);
        $this->assertEquals($expected, $resultB);
        $files->shouldHaveReceived('get')->once();
    }

    /** @test */
    public function can_render_inline_icons_from_nested_folders_with_dot_notation()
    {
        $factory = new SvgFactory(['inline' => true, 'class' => 'icon', 'svg_path' => __DIR__.'/resources/icons/']);
        $result = $factory->svg('foo.bar.arrow-thick-down')->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 10V2H7v8H2l8 8 8-8h-5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }
}

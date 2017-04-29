<?php

use BladeSvg\IconFactory;
use Illuminate\Support\HtmlString;
use Illuminate\Filesystem\Filesystem;

class IconFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function can_render_spritesheet()
    {
        $factory = new IconFactory(['spritesheet_path' => __DIR__.'/resources/sprite.svg']);
        $result = $factory->spritesheet();
        $expected = sprintf('<div style="height: 0; width: 0; position: absolute; visibility: hidden;">%s</div>', file_get_contents(__DIR__.'/resources/sprite.svg'));
        $this->assertEquals($expected, (string) $result);
    }

    /** @test */
    public function icons_are_rendered_from_spritesheet_by_default()
    {
        $factory = new IconFactory(['class' => 'icon']);
        $result = $factory->icon('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function icons_are_given_the_icon_class_by_default()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_from_spritesheet()
    {
        $factory = new IconFactory(['inline' => false, 'class' => 'icon']);
        $result = $factory->icon('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_inline_icon()
    {
        $factory = new IconFactory(['inline' => true, 'class' => 'icon', 'icon_path' => __DIR__.'/resources/icons/']);
        $result = $factory->icon('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_render_icon_with_additional_classes()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up', 'icon-lg inline-block')->toHtml();
        $expected = '<svg class="icon icon-lg inline-block"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_specify_additional_attributes_as_an_array()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up', 'icon-lg', ['alt' => 'Alt text', 'id' => 'arrow-icon'])->toHtml();
        $expected = '<svg class="icon icon-lg" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_skip_class_parameter()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up', ['alt' => 'Alt text', 'id' => 'arrow-icon'])->toHtml();
        $expected = '<svg class="icon" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function attributes_without_keys_are_used_as_valueless_html_attributes()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up', ['alt' => 'Alt text', 'data-foo'])->toHtml();
        $expected = '<svg class="icon" alt="Alt text" data-foo><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function specifying_class_as_attribute_overrides_default_class()
    {
        $factory = new IconFactory(['class' => 'default']);
        $result = $factory->icon('arrow-thick-up', ['class' => 'overridden'])->toHtml();
        $expected = '<svg class="overridden"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_chain_additional_attributes()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up')->alt('Alt text')->id('arrow-icon')->toHtml();
        $expected = '<svg class="icon" alt="Alt text" id="arrow-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function camelcase_attributes_are_dash_cased_when_chaining()
    {
        $factory = new IconFactory();
        $result = $factory->icon('arrow-thick-up')->dataFoo('bar')->toHtml();
        $expected = '<svg class="icon" data-foo="bar"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_inline()
    {
        $factory = new IconFactory(['inline' => false, 'icon_path' => __DIR__.'/resources/icons/']);
        $result = $factory->icon('arrow-thick-up')->inline()->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_force_icon_to_render_from_spritesheet()
    {
        $factory = new IconFactory(['inline' => true, 'class' => 'icon']);
        $result = $factory->icon('arrow-thick-up')->sprite()->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function can_specify_an_id_prefix_for_sprited_icons()
    {
        $factory = new IconFactory(['inline' => false, 'class' => 'icon', 'sprite_prefix' => 'icon-']);
        $result = $factory->icon('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function inline_icons_are_cached()
    {
        $svgStub = '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';
        $files = Mockery::spy(Filesystem::class, ['get' => $svgStub]);
        $factory = new IconFactory(['inline' => true, 'icon_path' => __DIR__.'/resources/icons/'], $files);

        $resultA = $factory->icon('arrow-thick-up')->toHtml();
        $resultB = $factory->icon('arrow-thick-up')->toHtml();
        $expected = '<svg class="icon" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></svg>';

        $this->assertEquals($expected, $resultA);
        $this->assertEquals($expected, $resultB);
        $files->shouldHaveReceived('get')->once();
    }
}

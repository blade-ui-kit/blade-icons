<?php

use Zondicons\ZondiconFactory;

class ZondiconFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function can_render_icon_from_spritesheet()
    {
        $factory = new ZondiconFactory(['inline' => false]);
        $result = $factory->icon('arrow-thick-up')->__toString();
        $expected = '<svg class="zondicon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicons-arrow-thick-up"></use></svg>';
        $this->assertEquals($expected, $result);
    }
}

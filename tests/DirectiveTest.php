<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\Blade;

class DirectiveTest extends TestCase
{
    /** @test */
    public function views_can_render_the_svg_directive()
    {
        $compiled = Blade::compileString("@svg('camera', 'text-gray-500', ['style' => 'color: #fff'])");

        $expected = "<?php echo e(svg('camera', 'text-gray-500', ['style' => 'color: #fff'])); ?>";

        $this->assertSame($expected, $compiled);
    }

    /** @test */
    public function views_can_render_the_sprite_directive()
    {
        $compiled = Blade::compileString("@sprite('camera', 'text-gray-500', ['style' => 'color: #fff'])");

        $expected = "<?php echo e(sprite('camera', 'text-gray-500', ['style' => 'color: #fff'])); ?>";

        $this->assertSame($expected, $compiled);
    }
    /** @test */

    public function views_can_render_the_spriteSheet_directive()
    {
        $compiled = Blade::compileString("@spriteSheet('camera')");

        $expected = "<?php echo e(sprite_sheet('camera')); ?>";

        $this->assertSame($expected, $compiled);
    }
}

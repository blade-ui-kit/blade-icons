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
}

<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\SpriteSheet;
use PHPUnit\Framework\TestCase;

class SpriteSheetTest extends TestCase
{
    /** @test */
    public function it_can_compile_to_html_from_a_path()
    {
        $spriteSheet = new SpriteSheet(__DIR__ . '/resources/sprite-sheet.svg');

        $expected = <<<HTML
<div style="height: 0; width: 0; position: absolute; visibility: hidden;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <symbol viewBox="0 0 20 20" id="arrow-thick-up"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></symbol>
    <symbol viewBox="0 0 20 20" id="backward"><path d="M19 5l-9 5 9 5V5zm-9 0l-9 5 9 5V5z" fill-rule="evenodd"/></symbol>
</svg>
</div>
HTML;

        $this->assertSame($expected, $spriteSheet->toHtml());
    }

    /** @test */
    public function it_can_compile_to_html_from_an_url()
    {
        $spriteSheet = new SpriteSheet(__DIR__ . '/resources/sprite-sheet.svg');

        $expected = <<<HTML
<div style="height: 0; width: 0; position: absolute; visibility: hidden;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <symbol viewBox="0 0 20 20" id="arrow-thick-up"><path d="M7 10v8h6v-8h5l-8-8-8 8h5z" fill-rule="evenodd"/></symbol>
    <symbol viewBox="0 0 20 20" id="backward"><path d="M19 5l-9 5 9 5V5zm-9 0l-9 5 9 5V5z" fill-rule="evenodd"/></symbol>
</svg>
</div>
HTML;

        $this->assertSame($expected, $spriteSheet->toHtml());
    }
}

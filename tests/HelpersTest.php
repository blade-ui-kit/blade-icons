<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Factory;
use BladeUI\Icons\Sprite;
use BladeUI\Icons\SpriteSheet;
use BladeUI\Icons\Svg;

class HelpersTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        require_once __DIR__ . '/../src/helpers.php';
    }

    /** @test */
    public function the_svg_helper_returns_an_svg_instance()
    {
        $this->prepareSets();

        $svg = svg('camera');

        $this->assertInstanceOf(Svg::class, $svg);
    }

    /** @test */
    public function the_sprite_helper_returns_a_sprite_instance()
    {
        $this->prepareSets();

        $sprite = sprite('tests:camera');

        $this->assertInstanceOf(Sprite::class, $sprite);
    }

    /** @test */
    public function the_sprite_sheet_helper_returns_a_spriteSheet_instance()
    {
        $this->prepareSets();

        // Default sprite sheet.
        $spriteSheet = sprite_sheet();

        $this->assertInstanceOf(SpriteSheet::class, $spriteSheet);

        $spriteSheet = sprite_sheet('tests');

        $this->assertInstanceOf(SpriteSheet::class, $spriteSheet);
    }

    protected function prepareSets(string $defaultClass = ''): Factory
    {
        return parent::prepareSets($defaultClass)->add('tests', [
            'path' => __DIR__ . '/resources/svg',
            'component-prefix' => 'tests',
            'sprite-sheet' => [
                'path' => __DIR__ . '/resources/sprite-sheet.svg',
                'url' => 'http://example.com',
            ],
        ]);
    }
}

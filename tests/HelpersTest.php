<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Factory;
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

    protected function prepareSets(string $defaultClass = ''): Factory
    {
        return parent::prepareSets($defaultClass)->add('tests', [
            'path' => __DIR__ . '/resources/svg',
            'component-prefix' => 'tests',
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\IconsManifest;
use Illuminate\Filesystem\Filesystem;

class IconsManifestTest extends TestCase
{
    /** @var string */
    private $manifestPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manifestPath = __DIR__ . '/fixtures/blade-icons.php';
        @unlink($this->manifestPath);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        @unlink($this->manifestPath);
    }

    private function expectedManifest(): string
    {
        return trim(str_replace(
            '{{ DIR }}',
            __DIR__,
            file_get_contents(__DIR__ . '/fixtures/generated-manifest.php')
        ));
    }

    /** @test */
    public function it_can_build_the_manifest_file()
    {
        $factory = $this->prepareSets();
        $manifest = new IconsManifest(new Filesystem(), $this->manifestPath, $factory->all());
        $manifest->build();

        $this->assertTrue(file_exists($this->manifestPath));
        $this->assertSame($this->expectedManifest(), file_get_contents($this->manifestPath));
    }

    /** @test */
    public function it_can_delete_the_manifest_file()
    {
        $manifest = new IconsManifest(new Filesystem(), $this->manifestPath, []);
        $manifest->build();

        $this->assertTrue(file_exists($this->manifestPath));
        $this->assertTrue($manifest->delete());
        $this->assertFalse(file_exists($this->manifestPath));
    }
}

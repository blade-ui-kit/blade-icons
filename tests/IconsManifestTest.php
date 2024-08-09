<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\IconsManifest;
use Exception;
use Illuminate\Filesystem\Filesystem;

class IconsManifestTest extends TestCase
{
    private string $manifestPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manifestPath = __DIR__.'/fixtures/blade-icons.php';
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
            ['{{ dir }}', '/'],
            [__DIR__, DIRECTORY_SEPARATOR],
            file_get_contents(__DIR__.'/fixtures/generated-manifest.php'),
        ));
    }

    /** @test */
    public function it_can_write_the_manifest_file()
    {
        $manifest = new IconsManifest(new Filesystem, $this->manifestPath);
        $manifest->write($this->prepareSets()->all());

        $this->assertTrue(file_exists($this->manifestPath));
        $this->assertEquals(
            $this->expectedManifest(),
            stripslashes(str_replace(
                ["\n", '=> '.PHP_EOL],
                [PHP_EOL, '=>'.PHP_EOL],
                file_get_contents($this->manifestPath)
            )),
        );
    }

    /** @test */
    public function it_can_delete_the_manifest_file()
    {
        $manifest = new IconsManifest(new Filesystem, $this->manifestPath);
        $manifest->write([]);

        $this->assertTrue(file_exists($this->manifestPath));
        $this->assertTrue($manifest->delete());
        $this->assertFalse(file_exists($this->manifestPath));
    }

    /** @test */
    public function it_throws_an_exceptiion_when_the_manifest_path_is_not_present_or_writable()
    {
        $manifest = new IconsManifest(new Filesystem, '/foo/bar.php');

        try {
            $manifest->write([]);
        } catch (Exception $e) {
            $this->assertSame('The /foo directory must be present and writable.', $e->getMessage());

            return;
        }

        $this->fail('Trying to write to an unpresent or unwritable directory succeeded.');
    }

    /** @test */
    public function it_can_get_the_manifest()
    {
        $manifest = new IconsManifest(new Filesystem, $this->manifestPath);

        $this->assertSame([], $manifest->getManifest([]));
    }
}

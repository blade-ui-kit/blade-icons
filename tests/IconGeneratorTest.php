<?php

declare(strict_types=1);

namespace Tests;

use BladeUI\Icons\Generation\IconGenerator;
use Illuminate\Filesystem\Filesystem;
use SplFileInfo;

class IconGeneratorTest extends TestCase
{
    const RESULT_DIR = __DIR__.'/fixtures/tmp';

    private function clearResultsDirectory(): void
    {
        $fs = new Filesystem;

        if ($fs->isDirectory(static::RESULT_DIR)) {
            $fs->deleteDirectory(static::RESULT_DIR);
        }
    }

    /** @test */
    public function it_can_generate_icon_sets()
    {
        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
            ],
            [
                'source' => __DIR__.'/resources/svg/solid',
                'destination' => static::RESULT_DIR.'/solid',
            ],
        ])->generate();

        $this->assertDirectoryExists(static::RESULT_DIR.'/primary');
        $this->assertDirectoryExists(static::RESULT_DIR.'/solid');
        $this->assertFileDoesNotExist(static::RESULT_DIR.'/primary/invalid-extension.txt');
        $this->assertFileExists(static::RESULT_DIR.'/primary/camera.svg');
        $this->assertFileExists(static::RESULT_DIR.'/solid/camera.svg');

        $this->clearResultsDirectory();
    }

    /** @test */
    public function it_will_clear_icons_before_generation_with_safe_mode_off()
    {
        // Run once to generate the "OLD" icons
        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
            ],
            [
                'source' => __DIR__.'/resources/svg/solid',
                'destination' => static::RESULT_DIR.'/solid',
            ],
        ])->generate();

        $this->assertDirectoryExists(static::RESULT_DIR.'/primary');
        $this->assertDirectoryExists(static::RESULT_DIR.'/solid');
        $this->assertFileExists(static::RESULT_DIR.'/primary/camera.svg');
        $this->assertFileExists(static::RESULT_DIR.'/solid/camera.svg');

        // Manually insert an "OLD ICON" that's been "removed".
        file_put_contents(static::RESULT_DIR.'/primary/cold-beans.svg', 'COOL BEANS!');
        $this->assertFileExists(static::RESULT_DIR.'/primary/cold-beans.svg');

        // Regenerate with Safe mode ON to verify "old" icons will be kept...
        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
                'safe' => true,
            ],
            [
                'source' => __DIR__.'/resources/svg/solid',
                'destination' => static::RESULT_DIR.'/solid',
                'safe' => true,
            ],
        ])->generate();

        $this->assertFileExists(static::RESULT_DIR.'/primary/cold-beans.svg');

        // Regenerate the icons with safe feature enabled.
        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
            ],
            [
                'source' => __DIR__.'/resources/svg/solid',
                'destination' => static::RESULT_DIR.'/solid',
            ],
        ])->generate();

        $this->assertFileDoesNotExist(static::RESULT_DIR.'/primary/cold-beans.svg');

        $this->clearResultsDirectory();
    }

    /** @test */
    public function it_can_use_generator_hooks()
    {
        $comment = '<!-- ICONS TEST --->'.PHP_EOL;

        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
                'after' => static function (
                    string $tempFilepath,
                    array $iconSet,
                    SplFileInfo $file
                ) use ($comment) {
                    $fileContents = file_get_contents($tempFilepath);
                    file_put_contents($tempFilepath, $comment.$fileContents);
                },
            ],
        ])->generate();

        $this->assertDirectoryExists(static::RESULT_DIR.'/primary');
        $this->assertFileExists(static::RESULT_DIR.'/primary/camera.svg');

        $iconContent = file_get_contents(static::RESULT_DIR.'/primary/camera.svg');
        $this->assertStringStartsWith($comment, $iconContent);

        $this->clearResultsDirectory();
    }

    /** @test */
    public function it_will_remove_and_apply_prefixes()
    {
        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
                'input-prefix' => 'zondicon-',
                'output-prefix' => 'blade-',
            ],
        ])->generate();

        $this->assertDirectoryExists(static::RESULT_DIR.'/primary');
        $this->assertFileExists(static::RESULT_DIR.'/primary/blade-flag.svg');
        $this->assertFileExists(static::RESULT_DIR.'/primary/blade-camera.svg');
        $this->assertFileExists(static::RESULT_DIR.'/primary/blade-foo-camera.svg');

        $this->clearResultsDirectory();
    }

    /** @test */
    public function it_will_remove_and_apply_suffixes()
    {
        IconGenerator::create([
            [
                'source' => __DIR__.'/resources/svg',
                'destination' => static::RESULT_DIR.'/primary',
                'input-suffix' => '-camera',
                'output-suffix' => '-wonky',
            ],
        ])->generate();

        $this->assertDirectoryExists(static::RESULT_DIR.'/primary');
        $this->assertFileExists(static::RESULT_DIR.'/primary/zondicon-flag-wonky.svg');
        $this->assertFileExists(static::RESULT_DIR.'/primary/camera-wonky.svg');
        $this->assertFileExists(static::RESULT_DIR.'/primary/foo-wonky.svg');

        $this->clearResultsDirectory();
    }
}

<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\Finder\SplFileInfo;

final class IconGenerator
{
    private Filesystem $filesystem;

    private array $sets;

    public function __construct(array $sets)
    {
        $this->filesystem = new Filesystem;
        $this->sets = $sets;
    }

    public static function create(array $config): self
    {
        return new self($config);
    }

    public function generate(): void
    {
        foreach ($this->sets as $set) {
            $destination = $this->getDestinationDirectory($set);
            $files = array_filter(
                $this->filesystem->files($set['source']),
                fn (SplFileInfo $value) => str_ends_with($value->getFilename(), '.svg')
            );

            foreach ($files as $file) {
                $filename = Str::of($file->getFilename());
                $filename = $this->applyPrefixes($set, $filename);
                $filename = $this->applySuffixes($set, $filename);
                $pathname = $destination.$filename;

                $this->filesystem->copy($file->getRealPath(), $pathname);

                if (is_callable($set['after'] ?? null)) {
                    $set['after']($pathname, $set, $file);
                }
            }
        }
    }

    private function getDestinationDirectory(array $set): string
    {
        $destination = Str::finish($set['destination'], DIRECTORY_SEPARATOR);

        if (! Arr::get($set, 'safe', false)) {
            $this->filesystem->deleteDirectory($destination);
        }

        $this->filesystem->ensureDirectoryExists($destination);

        return $destination;
    }

    private function applyPrefixes($set, Stringable $filename): Stringable
    {
        if ($set['input-prefix'] ?? false) {
            $filename = $filename->after($set['input-prefix']);
        }

        if ($set['output-prefix'] ?? false) {
            $filename = $filename->prepend($set['output-prefix']);
        }

        return $filename;
    }

    private function applySuffixes($set, Stringable $filename): Stringable
    {
        if ($set['input-suffix'] ?? false) {
            $filename = $filename->replace($set['input-suffix'].'.svg', '.svg');
        }

        if ($set['output-suffix'] ?? false) {
            $filename = $filename->replace('.svg', $set['output-suffix'].'.svg');
        }

        return $filename;
    }
}

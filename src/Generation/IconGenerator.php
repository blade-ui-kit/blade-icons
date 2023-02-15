<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use ReflectionFunction;
use Symfony\Component\Finder\SplFileInfo;

final class IconGenerator
{
    private Filesystem $filesystem;

    /**
     * @var IconSetConfig[]
     */
    private array $sets;

    public function __construct(array $sets)
    {
        $this->filesystem = new Filesystem();
        $this->sets = $sets;
    }

    /**
     * @param array<int, IconSetConfig|array<string, mixed>> $configs
     * @return static
     */
    public static function create(array $configs): self
    {
        /**
         * @var IconSetConfig[] $parsed
         */
        $parsed = [];
        foreach ($configs as $config) {
            if ($config instanceof IconSetConfig) {
                $parsed[] = $config;
            } else {
                $parsed[] = IconSetConfig::tryFromArray($config);
            }
        }
        return new self($parsed);
    }

    public function generate(): void
    {
        /**
         * @var IconSetConfig $set
         */
        foreach ($this->sets as $set) {
            $destination = $this->getDestinationDirectory($set);
            $files = array_filter(
                $this->filesystem->files($set->source),
                fn (SplFileInfo $value) => str_ends_with($value->getFilename(), '.svg')
            );

            foreach ($files as $file) {
                $filename = Str::of($file->getFilename());
                $filename = $this->applyPrefixes($set, $filename);
                $filename = $this->applySuffixes($set, $filename);
                $pathname = $destination.$filename;

                $this->filesystem->copy($file->getRealPath(), $pathname);

                if (!is_null($set->after)) {
                    $reflectHook = new ReflectionFunction($set->after);
                    if ($reflectHook->getParameters()[1]->getType()->getName() === 'array') {
                        ($set->after)($pathname, $set->toArray(), $file);
                    } else {
                        ($set->after)($pathname, $set, $file);
                    }
                }
            }
        }
    }

    private function getDestinationDirectory(IconSetConfig $set): string
    {
        $destination = Str::finish($set->destination, DIRECTORY_SEPARATOR);

        if (! $set->safe) {
            $this->filesystem->deleteDirectory($destination);
        }

        $this->filesystem->ensureDirectoryExists($destination);

        return $destination;
    }

    private function applyPrefixes(IconSetConfig $set, Stringable $filename): Stringable
    {
        if ($set->inputPrefix !== '') {
            $filename = $filename->after($set->inputPrefix);
        }

        if ($set->outputPrefix !== '') {
            $filename = $filename->prepend($set->outputPrefix);
        }

        return $filename;
    }

    private function applySuffixes(IconSetConfig $set, Stringable $filename): Stringable
    {
        if ($set->inputSuffix !== '') {
            $filename = $filename->replace($set->inputSuffix.'.svg', '.svg');
        }

        if ($set->outputSuffix ?? false) {
            $filename = $filename->replace('.svg', $set->outputSuffix.'.svg');
        }

        return $filename;
    }
}

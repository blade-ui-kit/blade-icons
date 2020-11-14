<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Components\Svg as SvgComponent;
use BladeUI\Icons\Exceptions\CannotRegisterIconSet;
use BladeUI\Icons\Exceptions\SvgNotFound;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

final class Factory
{
    /** @var Filesystem */
    private $filesystem;

    /** @var string */
    private $defaultClass;

    /** @var array */
    private $sets = [];

    /** @var array */
    private $cache = [];

    public function __construct(Filesystem $filesystem, string $defaultClass = '')
    {
        $this->filesystem = $filesystem;
        $this->defaultClass = $defaultClass;
    }

    public function all(): array
    {
        return $this->sets;
    }

    /**
     * @throws CannotRegisterIconSet
     */
    public function add(string $set, array $options): self
    {
        if (empty($options['paths'])) {
            $options['paths'] = [$options['path']];
        }

        if (empty($options['paths'])) {
            throw CannotRegisterIconSet::pathNotDefined($set);
        }

        if (! isset($options['prefix'])) {
            throw CannotRegisterIconSet::prefixNotDefined($set);
        }

        if ($collidingSet = $this->getSetByPrefix($options['prefix'])) {
            throw CannotRegisterIconSet::prefixNotUnique($set, $collidingSet);
        }

        // @TODO
        // We could remove this because we internally will always use
        // the "paths" array which wraps "path" if it is used instead of
        // the "paths" array. This guarantees that we always handle all paths.
        if (isset($options['path'])) {
            $options['path'] = rtrim($options['path'], '/');
        }

        $options['paths'] = array_map(function ($path) {
            return rtrim($path, '/');
        }, $options['paths']);

        foreach ($options['paths'] as $path) {
            if ($this->filesystem->missing($path)) {
                throw CannotRegisterIconSet::nonExistingPath($set, $path);
            }
        }

        $this->sets[$set] = $options;

        $this->cache = [];

        return $this;
    }

    public function registerComponents(): void
    {
        foreach ($this->sets as $set) {
            foreach ($set['paths'] as $path) {
                foreach ($this->filesystem->allFiles($path) as $file) {
                    if ($file->getExtension() !== 'svg') {
                        continue;
                    }

                    $filePath = array_filter(explode('/', Str::after($file->getPath(), $path)));

                    Blade::component(
                        SvgComponent::class,
                        implode('.', array_filter($filePath + [$file->getFilenameWithoutExtension()])),
                        $set['prefix']
                    );
                }
            }
        }
    }

    /**
     * @throws SvgNotFound
     */
    public function svg(string $name, $class = '', array $attributes = []): Svg
    {
        [$set, $name] = $this->splitSetAndName($name);

        return new Svg($name, $this->contents($set, $name), $this->formatAttributes($set, $class, $attributes));
    }

    /**
     * @throws SvgNotFound
     */
    private function contents(string $set, string $name): string
    {
        if (isset($this->cache[$set][$name])) {
            return $this->cache[$set][$name];
        }

        if (isset($this->sets[$set])) {
            foreach ($this->sets[$set]['paths'] as $path) {
                try {
                    return $this->cache[$set][$name] = $this->getSvgFromPath($name, $path);
                } catch (FileNotFoundException $exception) {
                    //
                }
            }
        }

        throw SvgNotFound::missing($set, $name);
    }

    private function getSvgFromPath(string $name, string $path): string
    {
        return trim($this->filesystem->get(sprintf(
            '%s/%s.svg',
            rtrim($path),
            str_replace('.', '/', $name),
        )));
    }

    private function splitSetAndName(string $name): array
    {
        $prefix = Str::before($name, '-');

        $set = $this->getSetByPrefix($prefix);

        $name = $set ? Str::after($name, '-') : $name;

        return [$set ?? 'default', $name];
    }

    private function getSetByPrefix(string $prefix): ?string
    {
        return collect($this->sets)->where('prefix', $prefix)->keys()->first();
    }

    private function formatAttributes(string $set, $class = '', array $attributes = []): array
    {
        if (is_string($class)) {
            if ($class = $this->buildClass($set, $class)) {
                $attributes['class'] = $attributes['class'] ?? $class;
            }
        } elseif (is_array($class)) {
            $attributes = $class;

            if (! isset($attributes['class']) && $class = $this->buildClass($set, '')) {
                $attributes['class'] = $class;
            }
        }

        return $attributes;
    }

    private function buildClass(string $set, string $class): string
    {
        return trim(sprintf(
            '%s %s',
            trim(sprintf('%s %s', $this->defaultClass, $this->sets[$set]['class'] ?? '')),
            $class,
        ));
    }
}

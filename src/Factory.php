<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Components\Svg as SvgComponent;
use BladeUI\Icons\Exceptions\CannotRegisterIconSet;
use BladeUI\Icons\Exceptions\SvgNotFound;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;

final class Factory
{
    /** @var Filesystem */
    private $filesystem;

    /** @var FilesystemFactory|null */
    private $disks;

    /** @var string */
    private $defaultClass;

    /** @var string */
    private $fallback;

    /** @var array */
    private $sets = [];

    /** @var array */
    private $cache = [];

    public function __construct(Filesystem $filesystem, FilesystemFactory $disks = null, array $config = [])
    {
        $this->filesystem = $filesystem;
        $this->disks = $disks;
        $this->defaultClass = $config['class'] ?? '';
        $this->fallback = $config['fallback'] ?? '';
    }

    /**
     * @internal This method is only meant for testing purposes and does not fall under the package's BC promise.
     */
    public function all(): array
    {
        return $this->sets;
    }

    /**
     * @throws CannotRegisterIconSet
     */
    public function add(string $set, array $options): self
    {
        if (! isset($options['prefix'])) {
            throw CannotRegisterIconSet::prefixNotDefined($set);
        }

        if ($collidingSet = $this->getSetByPrefix($options['prefix'])) {
            throw CannotRegisterIconSet::prefixNotUnique($set, $collidingSet);
        }

        $paths = (array) ($options['paths'] ?? $options['path'] ?? []);

        $options['paths'] = array_filter(array_map(function ($path) {
            return $path !== '/' ? rtrim($path, '/') : $path;
        }, $paths));

        if (empty($options['paths'])) {
            throw CannotRegisterIconSet::pathsNotDefined($set);
        }

        unset($options['path']);

        $filesystem = $this->filesystem($options['disk'] ?? null);

        foreach ($options['paths'] as $path) {
            if ($path !== '/' && $filesystem->missing($path)) {
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
                foreach ($this->filesystem($options['disk'] ?? null)->allFiles($path) as $file) {
                    if ($file->getExtension() !== 'svg') {
                        continue;
                    }

                    $parts = array_filter(explode('/', Str::after($file->getPath(), $path)));

                    Blade::component(
                        SvgComponent::class,
                        implode('.', array_filter($parts + [$file->getFilenameWithoutExtension()])),
                        $set['prefix'],
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

        try {
            return new Svg(
                $name,
                $this->contents($set, $name),
                $this->formatAttributes($set, $class, $attributes),
            );
        } catch (SvgNotFound $exception) {
            if (isset($this->sets[$set]['fallback']) && $this->sets[$set]['fallback'] !== '') {
                $name = $this->sets[$set]['fallback'];

                try {
                    return new Svg(
                        $name,
                        $this->contents($set, $name),
                        $this->formatAttributes($set, $class, $attributes),
                    );
                } catch (SvgNotFound $exception) {
                    //
                }
            }

            if ($this->fallback) {
                return $this->svg($this->fallback, $class, $attributes);
            }

            throw $exception;
        }
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
                    return $this->cache[$set][$name] = $this->getSvgFromPath(
                        $name,
                        $path,
                        $this->sets[$set]['disk'] ?? null
                    );
                } catch (FileNotFoundException $exception) {
                    //
                }
            }
        }

        throw SvgNotFound::missing($set, $name);
    }

    private function getSvgFromPath(string $name, string $path, ?string $disk = null): string
    {
        return trim($this->filesystem($disk)->get(sprintf(
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

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|Filesystem
     */
    private function filesystem(?string $disk = null)
    {
        return $this->disks && $disk ? $this->disks->disk($disk) : $this->filesystem;
    }
}

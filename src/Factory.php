<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use BladeUI\Icons\Components\Svg as SvgComponent;
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

    public function add(string $set, array $options): self
    {
        $this->sets[$set] = $options;

        $this->registerComponents($options);

        $this->cache = [];

        return $this;
    }

    private function registerComponents(array $options): void
    {
        if (isset($options['path']) && isset($options['component-prefix']) && $this->filesystem->exists($options['path'])) {
            foreach ($this->filesystem->allFiles($options['path']) as $file) {
                $path = array_filter(explode('/', Str::after($file->getPath(), $options['path'])));

                Blade::component(
                    SvgComponent::class,
                    implode('.', array_filter($path + [$file->getFilenameWithoutExtension()])),
                    $options['component-prefix']
                );
            }
        }
    }

    /**
     * @throws SvgNotFound
     */
    public function svg(string $name, $class = '', array $attributes = []): Svg
    {
        [$set, $name] = $this->splitSetAndName($name);

        return new Svg($name, $this->contents($set, $name), $this->formatAttributes($class, $attributes));
    }

    /**
     * @throws SvgNotFound
     */
    private function contents(string $set, string $name): string
    {
        $cacheKey = "$set:$name";

        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        if (isset($this->sets[$set]['path'])) {
            try {
                return $this->cache[$cacheKey] = $this->getSvgFromPath($name, $this->sets[$set]['path']);
            } catch (FileNotFoundException $exception) {
                //
            }
        }

        throw SvgNotFound::missing($set, $name);
    }

    private function getSvgFromPath(string $name, string $path): string
    {
        return trim($this->filesystem->get(sprintf(
            '%s/%s.svg',
            rtrim($path),
            str_replace('.', '/', $name)
        )));
    }

    private function splitSetAndName(string $name): array
    {
        $parts = explode(':', $name);

        if (count($parts) === 2) {
            return $parts;
        }

        return ['default', $parts[0]];
    }

    private function formatAttributes($class = '', array $attributes = []): array
    {
        if (is_string($class) && $class !== '') {
            $attributes['class'] = $this->buildClass($class);
        } elseif (is_array($class)) {
            $attributes = $class;
        }

        return $attributes;
    }

    private function buildClass(string $class): string
    {
        return trim(sprintf('%s %s', $this->defaultClass, $class));
    }
}

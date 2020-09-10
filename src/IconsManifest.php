<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

final class IconsManifest
{
    /** @var Filesystem */
    private $filesystem;

    /** @var array */
    private $manifest;

    /** @var string */
    private $manifestPath;

    /** @var array */
    private $sets;

    public function __construct(Filesystem $filesystem, string $manifestPath, array $sets)
    {
        $this->filesystem = $filesystem;
        $this->manifestPath = $manifestPath;
        $this->sets = $sets;
    }

    private function build(): array
    {
        $compiled = [];

        foreach ($this->sets as $name => $set) {
            foreach ($this->filesystem->allFiles($set['path']) as $file) {
                $set['icons'][] = $this->format($file, $set['path']);
            }

            $compiled[$name] = $set;
        }

        return $compiled;
    }

    public function delete(): bool
    {
        return $this->filesystem->delete($this->manifestPath);
    }

    private function format(SplFileInfo $file, string $path): string
    {
        return (string) Str::of($file->getPathName())
            ->after($path . '/')
            ->replace('/', '.')
            ->basename('.' . $file->getExtension());
    }

    public function getManifest(): array
    {
        if (! is_null($this->manifest)) {
            return $this->manifest;
        }

        if (! $this->filesystem->exists($this->manifestPath)) {
            return $this->manifest = $this->build();
        }

        return $this->manifest = $this->filesystem->getRequire($this->manifestPath);
    }

    /**
     * @throws Exception
     */
    public function write(): void
    {
        if (! is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }

        $this->filesystem->replace(
            $this->manifestPath,
            '<?php return ' . var_export($this->build(), true) . ';'
        );
    }
}

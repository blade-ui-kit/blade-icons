<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use Exception;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

final class IconsManifest
{
    private Filesystem $filesystem;

    private string $manifestPath;

    private ?FilesystemFactory $disks;

    private ?array $manifest = null;

    public function __construct(Filesystem $filesystem, string $manifestPath, ?FilesystemFactory $disks = null)
    {
        $this->filesystem = $filesystem;
        $this->manifestPath = $manifestPath;
        $this->disks = $disks;
    }

    private function build(array $sets): array
    {
        $compiled = [];

        foreach ($sets as $name => $set) {
            $icons = [];

            foreach ($set['paths'] as $path) {
                $icons[$path] = [];

                foreach ($this->filesystem($set['disk'] ?? null)->allFiles($path) as $file) {
                    if ($file instanceof SplFileInfo) {
                        if ($file->getExtension() !== 'svg') {
                            continue;
                        }

                        $icons[$path][] = $this->format($file->getPathName(), $path);
                    } else {
                        if (! Str::endsWith($file, '.svg')) {
                            continue;
                        }

                        $icons[$path][] = $this->format($file, $path);
                    }
                }

                $icons[$path] = array_unique($icons[$path]);
            }

            $compiled[$name] = array_filter($icons);
        }

        return $compiled;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem|Filesystem
     */
    private function filesystem(?string $disk = null)
    {
        return $this->disks && $disk ? $this->disks->disk($disk) : $this->filesystem;
    }

    public function delete(): bool
    {
        return $this->filesystem->delete($this->manifestPath);
    }

    private function format(string $pathname, string $path): string
    {
        return (string) Str::of($pathname)
            ->after($path.DIRECTORY_SEPARATOR)
            ->replace(DIRECTORY_SEPARATOR, '.')
            ->basename('.svg');
    }

    public function getManifest(array $sets): array
    {
        if (! is_null($this->manifest)) {
            return $this->manifest;
        }

        if (! $this->filesystem->exists($this->manifestPath)) {
            return $this->manifest = $this->build($sets);
        }

        return $this->manifest = $this->filesystem->getRequire($this->manifestPath);
    }

    /**
     * @throws Exception
     */
    public function write(array $sets): void
    {
        if (! is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }

        $this->filesystem->replace(
            $this->manifestPath,
            '<?php return '.var_export($this->build($sets), true).';',
        );
    }
}

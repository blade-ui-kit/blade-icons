<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use Exception;
use FilesystemIterator;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
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
            $disk = $set['disk'] ?? null;

            foreach ($set['paths'] as $path) {
                $found = $disk
                    ? $this->scanDisk($disk, $path)
                    : $this->scanLocal($path);

                sort($found);

                $icons[$path] = $found;
            }

            $compiled[$name] = array_filter($icons);
        }

        return $compiled;
    }

    /**
     * Fast local-filesystem scan. Bypasses Symfony Finder (used by
     * Illuminate\Filesystem\Filesystem::allFiles) because it adds significant
     * per-file overhead for large icon libraries where a single set can hold
     * tens of thousands of SVGs.
     */
    private function scanLocal(string $path): array
    {
        if (! is_dir($path)) {
            return [];
        }

        $seen = [];
        $prefixLength = strlen($path) + 1;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            $pathname = $file->getPathname();

            if (substr($pathname, -4) !== '.svg') {
                continue;
            }

            $relative = substr($pathname, $prefixLength, -4);

            if (DIRECTORY_SEPARATOR !== '.') {
                $relative = str_replace(DIRECTORY_SEPARATOR, '.', $relative);
            }

            $seen[$relative] = true;
        }

        return array_keys($seen);
    }

    private function scanDisk(string $disk, string $path): array
    {
        $seen = [];

        foreach ($this->filesystem($disk)->allFiles($path) as $file) {
            if ($file instanceof SplFileInfo) {
                if ($file->getExtension() !== 'svg') {
                    continue;
                }

                $seen[$this->format($file->getPathName(), $path)] = true;
            } else {
                if (! Str::endsWith($file, '.svg')) {
                    continue;
                }

                $seen[$this->format($file, $path)] = true;
            }
        }

        return array_keys($seen);
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

        $this->manifest = $this->build($sets);

        $this->filesystem->replace(
            $this->manifestPath,
            '<?php return '.var_export($this->manifest, true).';',
        );
    }
}

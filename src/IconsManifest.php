<?php

declare(strict_types=1);

namespace BladeUI\Icons;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class IconsManifest
{
    /** @var Filesystem */
    private $filesystem;

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

    public function build(): void
    {
        $compiled = [];

        foreach ($this->sets as $name => $set) {
            foreach ($this->filesystem->allFiles($set['path']) as $file) {
                $path = array_filter(explode('/', Str::after($file->getPath(), $set['path'])));

                $set['icons'][] = implode('.', array_filter($path + [$file->getFilenameWithoutExtension()]));
            }

            $compiled[$name] = $set;
        }

        $this->write($compiled);
    }

    public function delete(): bool
    {
        return $this->filesystem->delete($this->manifestPath);
    }

    private function write(array $manifest): void
    {
        $this->filesystem->replace(
            $this->manifestPath,
            '<?php return ' . var_export($manifest, true) . ';'
        );
    }
}

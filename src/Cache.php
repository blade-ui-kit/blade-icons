<?php


namespace BladeUI\Icons;


use Illuminate\Filesystem\Filesystem;

class Cache
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $path;

    /** @var array */
    private $cache = [];

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->path = base_path('bootstrap/cache/blade-icons.php');

        if ($this->filesystem->exists($this->path)) {
            $this->cache = require($this->path);
        }
    }

    public function get(string $name, array $set)
    {
        if (isset($this->cache[$name]) === false) {
            return $this->updateCache($name, $set);
        }

        return $this->cache[$name];
    }

    private function updateCache(string $name, array $set) {
        $meta = $this->readSetMetaFromFilesystem($set);

        $this->cache[$name] = $meta;

        $this->filesystem->put(
            $this->path,
            '<?php return '.var_export($this->cache, true).';'.PHP_EOL
        );

        return $meta;
    }

    private function readSetMetaFromFilesystem(array $set) {
        $meta = [];

        foreach ($this->filesystem->allFiles($set['path']) as $file) {
            $meta[] = [
                'extension' => $file->getExtension(),
                'path' => $file->getPath(),
                'filename' => $file->getFilename(),
            ];
        }

        return $meta;
    }
}

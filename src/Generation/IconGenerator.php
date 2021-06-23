<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Finder\SplFileInfo;

final class IconGenerator
{
    private Filesystem $filesystem;

    private string $library;

    private string $root;

    private array $sets = [];

    private ?Closure $svgNormalizationClosure = null;

    private bool $useSingleIconSet = false;

    private bool $deleteExistingIcons = true;

    private function __construct(string $library)
    {
        $this->filesystem = new Filesystem();
        $this->library = $library;
        $this->root = getcwd();
    }

    public static function create(string $set): self
    {
        return new self($set);
    }

    public function withIconSets(array $sets): self
    {
        $this->sets = $sets;

        return $this;
    }

    public function withSvgNormalisation(Closure $svgNormalizationClosure): self
    {
        $this->svgNormalizationClosure = $svgNormalizationClosure;

        return $this;
    }

    public function useSingleIconSet(): self
    {
        $this->useSingleIconSet = true;

        return $this;
    }

    public function preserveExistingIcons(): self
    {
        $this->deleteExistingIcons = false;

        return $this;
    }

    public function run()
    {
        return (new SingleCommandApplication())
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $output->writeln("Starting to generate icons for the {$this->library} package...");

                if ($this->deleteExistingIcons) {
                    $this->filesystem->deleteDirectory($this->defaultDestination());
                }

                $this->filesystem->ensureDirectoryExists($this->defaultDestination());

                foreach ($this->sets as $config) {
                    $iconFileList = $this->filesystem->files($config['source']);

                    $this->generateIcons($config, $iconFileList);
                }

                $output->writeln("Finished generating icons for the {$this->library} package!");

                return Command::SUCCESS;
            })
            ->run();
    }

    /**
     * @param SplFileInfo[] $icons
     */
    public function generateIcons(array $config, array $icons): void
    {
        foreach ($icons as $file) {
            $destination = Str::finish(
                $config['destination'] ?? $this->defaultDestination(), DIRECTORY_SEPARATOR
            );

            // Concat the set name onto the path...
            if (! $this->useSingleIconSet) {
                $destination .= $this->library.DIRECTORY_SEPARATOR;
            }

            $this->filesystem->ensureDirectoryExists($destination);

            $finalFile = Str::of($file->getFilename());

            if ($config['input-prefix'] ?? false) {
                $finalFile = $finalFile->after($config['input-prefix']);
            }

            if ($config['prefix'] ?? false) {
                $finalFile = $finalFile->prepend($config['prefix']);
            }

            $finalFile = $destination.$finalFile;

            // Copy to final destination...
            copy($file->getRealPath(), $finalFile);

            // Apply user transformations if they provide them...
            if ($this->svgNormalizationClosure !== null) {
                $normalizeSvgClosure = $this->svgNormalizationClosure;
                $normalizeSvgClosure($finalFile, $config);
            }
        }
    }

    private function defaultDestination(): string
    {
        return $this->root.'/resources/svg';
    }
}

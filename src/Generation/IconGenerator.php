<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use RuntimeException;
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

    private string $directory;

    private string $npm = '';

    private string $composer = '';

    private array $iconSets = [];

    private ?Closure $svgNormalizationClosure = null;

    private bool $useSingleIconSet = false;

    private bool $safe = false;

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

    public function directory(string $directory): self
    {
        $this->directory = trim($directory, DIRECTORY_SEPARATOR);

        return $this;
    }

    public function fromNPM(string $package): self
    {
        $this->npm = $package;

        return $this;
    }

    public function fromComposer(string $package): self
    {
        $this->composer = $package;

        return $this;
    }

    public function withIconSets(array $sets): self
    {
        $this->iconSets = $sets;

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

    public function safe(): self
    {
        $this->safe = true;

        return $this;
    }

    public function run()
    {
        return (new SingleCommandApplication())
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $output->writeln("Starting build process for {$this->library} icon pack.");

                if (! is_dir($this->getSvgSourcePath())) {
                    $output->writeln("The SVG source folder does not exist yet - check: <{$this->getSvgSourcePath()}>");

                    return Command::FAILURE;
                }

                // Clear the destination directory
                if (! $this->safe) {
                    $this->filesystem->deleteDirectory($this->baseSvgDestinationPath());

                    $this->ensureDirectoryExists($this->baseSvgDestinationPath());
                }

                $output->writeln('Discovering source SVGs for icon sets...');

                foreach ($this->iconSets as $set => $iconSetConfig) {
                    $output->writeln("Processing '{$set}' icon set SVGs.");

                    /**
                     * @var array<SplFileInfo> $iconFileList
                     */
                    $iconFileList = $this->filesystem->files($this->getSvgSourcePath().DIRECTORY_SEPARATOR.$set);

                    $this->updateIcons($iconSetConfig, $iconFileList);

                    $output->writeln("Completed processing for '{$set}' svgs.");
                }

                $output->writeln('Done!');

                return Command::SUCCESS;
            })
            ->run();
    }

    /**
     * @param SplFileInfo[] $iconFileList
     */
    public function updateIcons(array $iconSet, array $iconFileList): void
    {
        foreach ($iconFileList as $iconFile) {
            // Set path variables...
            $sourceFile = $iconFile->getRealPath();
            $destinationPath = Str::finish($this->getSvgDestinationPath($iconSet), DIRECTORY_SEPARATOR);

            // Concat the set name onto the path...
            if (! $this->useSingleIconSet) {
                $destinationPath .= $this->library.DIRECTORY_SEPARATOR;
            }

            if (($iconSet['input-prefix'] ?? false) && ($iconSet['output-prefix'] ?? false)) {
                $finalFile = $destinationPath.Str::of($iconFile->getFilename())->after($iconSet['input-prefix'])->prepend($iconSet['output-prefix']);
            } elseif ($iconSet['input-prefix'] ?? false) {
                $finalFile = $destinationPath.Str::of($iconFile->getFilename())->after($iconSet['input-prefix']);
            } elseif ($iconSet['output-prefix'] ?? false) {
                $finalFile = $destinationPath.Str::of($iconFile->getFilename())->prepend($iconSet['output-prefix']);
            } else {
                $finalFile = $destinationPath.$iconFile->getFilename();
            }

            // Copy to final destination...
            $this->ensureDirectoryExists($destinationPath);

            copy($sourceFile, $finalFile);

            // Apply user transformations if they provide them...
            if ($this->svgNormalizationClosure !== null) {
                $normalizeSvgClosure = $this->svgNormalizationClosure;
                $normalizeSvgClosure($finalFile, $iconSet);
            }
        }
    }

    private function getSvgSourcePath(): string
    {
        $path = '';

        if ($this->npm) {
            $path = 'node_modules'.DIRECTORY_SEPARATOR.$this->npm;
        } elseif ($this->composer) {
            $path = 'vendor'.DIRECTORY_SEPARATOR.$this->composer;
        }

        return implode(
            DIRECTORY_SEPARATOR,
            array_filter([$this->root, $path, $this->directory]),
        );
    }

    private function getSvgDestinationPath(array $iconSetConfig): string
    {
        return $iconSetConfig['destination'] ?? $this->baseSvgDestinationPath();
    }

    private function baseSvgDestinationPath(): string
    {
        return $this->root.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'svg';
    }

    private function ensureDirectoryExists($path)
    {
        $this->filesystem->ensureDirectoryExists($path);

        if (! is_dir($path)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }
}

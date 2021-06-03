<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

use Closure;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Finder\SplFileInfo;

final class IconGenerator
{
    private Filesystem $filesystem;

    private string $set;

    private string $root;

    private string $directory;

    private string $npm = '';

    private string $composer = '';

    /** @var IconSetConfig[] */
    private array $iconSets = [];

    private ?Closure $svgNormalizationClosure = null;

    private bool $useSingleIconSet = false;

    private bool $safe = false;

    private function __construct(string $set)
    {
        $this->filesystem = new Filesystem();
        $this->set = $set;
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

    /**
     * @param IconSetConfig[] $sets
     */
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
                $output->writeln("Starting build process for {$this->set} icon pack.");

                if (! is_dir($this->getSvgSourcePath())) {
                    $output->writeln("The SVG source folder does not exist yet - check: <{$this->getSvgSourcePath()}>");

                    return Command::FAILURE;
                }

                $tempDirPath = $this->getSvgTempPath();
                $this->ensureDirectoryExists($tempDirPath);

                // Clear the destination directory
                if (! $this->safe) {
                    $this->filesystem->deleteDirectory($this->getSvgDestinationPath());
                    $this->ensureDirectoryExists($this->getSvgDestinationPath());
                }

                $output->writeln('Discovering source SVGs for icon sets...');

                foreach ($this->iconSets as $iconSetConfig) {
                    $iconSetConfig->setTempPath($this->getSvgTempPath())
                                  ->setDestinationPath($this->getSvgDestinationPath());
                    $iconSetName = $iconSetConfig->set;
                    $output->writeln("Processing '{$iconSetName}' icon set SVGs.");

                    // Setup build dir for type
                    $iconSetTmpDir = $tempDirPath.DIRECTORY_SEPARATOR.$iconSetName;
                    $this->ensureDirectoryExists($iconSetTmpDir);

                    /**
                     * @var array<SplFileInfo> $iconFileList
                     */
                    $iconFileList = $this->filesystem->files($this->getSvgSourcePath().DIRECTORY_SEPARATOR.$iconSetName);
                    $this->updateIcons($iconSetConfig, $iconFileList);
                    $output->writeln("Completed processing for '{$iconSetName}' svgs.");
                }

                $output->writeln('Cleaning up the build directory...');

                $this->filesystem->deleteDirectory(static::getSvgTempPath());

                $output->writeln('Done!');

                return Command::SUCCESS;
            })
            ->run();
    }

    /**
     * @param SplFileInfo[] $iconFileList
     */
    public function updateIcons(IconSetConfig $iconSet, array $iconFileList): void
    {
        foreach ($iconFileList as $iconFile) {
            // Set path variables...
            $sourceFile = $iconFile->getRealPath();
            $tempFile = $iconSet->getTempFilePath($iconFile->getFilename());
            $finalFile = $iconSet->getDestinationFilePath($iconFile->getFilename(), $this->useSingleIconSet);

            // Copy file to temp...
            copy($sourceFile, $tempFile);

            // Apply user transformations if they provide them...
            if ($this->svgNormalizationClosure !== null) {
                $normalizeSvgClosure = $this->svgNormalizationClosure;
                $normalizeSvgClosure($tempFile, $iconSet);
            }

            // Copy to final destination...
            $this->ensureDirectoryExists(dirname($finalFile));

            copy($tempFile, $finalFile);
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

    private function getSvgTempPath(): string
    {
        return $this->root.DIRECTORY_SEPARATOR.'build';
    }

    private function getSvgDestinationPath(): string
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

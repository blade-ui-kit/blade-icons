<?php

namespace BladeUI\Icons\Console;

use Closure;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Finder\SplFileInfo;

class GenerateCommandBuilder
{
    private string $name;
    /**
     * @var false|string
     */
    private $baseDirectory;
    private string $sourceDirectory;
    private ?string $npmPackageName = null;
    private array $iconSets = [];
    private ?Closure $svgNormalizationClosure = null;
    private bool $useSingleIconSet = false;
    private bool $clearDestinationDirectory = false;

    private function __construct(string $name)
    {
        $this->name = $name;
        $this->baseDirectory = getcwd();
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function fromSourceSvgDirectory(string $sourceDirectory): self
    {
        $this->sourceDirectory = $sourceDirectory;

        return $this;
    }

    public function fromNpmPackage(string $packageName): self
    {
        $this->npmPackageName = $packageName;

        return $this;
    }

    public function withIconSets(array $iconSets): self
    {
        $this->iconSets = $iconSets;

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

    public function clearDestinationDirectory(): self
    {
        $this->clearDestinationDirectory = true;

        return $this;
    }

    public function run()
    {
        return (new SingleCommandApplication())
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $output->writeln("Starting build process for {$this->name} icon pack.");
                if (! is_dir($this->getSvgSourcePath())) {
                    $output->writeln("The SVG source folder does not exist yet - check: <{$this->getSvgSourcePath()}>");

                    return Command::FAILURE;
                }
                $tempDirPath = $this->getSvgTempPath();
                $this->ensureDirectoryExists($tempDirPath);

                // Clear the destination directory
                if ($this->clearDestinationDirectory) {
                    app(Filesystem::class)->deleteDirectory($this->getSvgDestinationPath());
                    $this->ensureDirectoryExists($this->getSvgDestinationPath());
                }

                $output->writeln('Discovering source SVGs for icon sets...');
                foreach ($this->iconSets as $iconSetConfig) {
                    /**
                     * @var IconSetConfig $iconSetConfig
                     */
                    $iconSetConfig->setTempPath($this->getSvgTempPath())
                                  ->setDestinationPath($this->getSvgDestinationPath());
                    $iconSetName = $iconSetConfig->name;
                    $output->writeln("Processing '{$iconSetName}' icon set SVGs.");

                    // Setup build dir for type
                    $iconSetTmpDir = $tempDirPath.DIRECTORY_SEPARATOR.$iconSetName;
                    $this->ensureDirectoryExists($iconSetTmpDir);

                    /**
                     * @var array<SplFileInfo> $iconFileList
                     */
                    $iconFileList = app(Filesystem::class)->files($this->getSvgSourcePath().DIRECTORY_SEPARATOR.$iconSetName);
                    $this->updateSvgs($iconSetConfig, $iconFileList);
                    $output->writeln("Completed processing for '{$iconSetName}' svgs.");
                }

                $output->writeln('Cleaning up the build directory...');
                app(Filesystem::class)->deleteDirectory(static::getSvgTempPath());
                $output->writeln('Done!');

                return Command::SUCCESS;
            })
            ->run();
    }

    private function getSvgSourcePath(): string
    {
        if ($this->npmPackageName !== null) {
            return $this->baseDirectory.DIRECTORY_SEPARATOR.
                'node_modules'.DIRECTORY_SEPARATOR.
                $this->npmPackageName.DIRECTORY_SEPARATOR.
                ltrim($this->sourceDirectory, DIRECTORY_SEPARATOR);
        }

        return $this->baseDirectory.DIRECTORY_SEPARATOR.ltrim($this->sourceDirectory, DIRECTORY_SEPARATOR);
    }

    private function getSvgTempPath(): string
    {
        return $this->baseDirectory.DIRECTORY_SEPARATOR.'build';
    }

    private function getSvgDestinationPath(): string
    {
        return $this->baseDirectory.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'svg';
    }

    private function ensureDirectoryExists($path)
    {
        app(Filesystem::class)->ensureDirectoryExists($path);
        if (! is_dir($path)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
    }

    /**
     * @param array<SplFileInfo>    $iconFileList
     */
    public function updateSvgs(IconSetConfig $iconSet, array $iconFileList): void
    {
        $iconSetName = $iconSet->name;
        $iconSetTmpDir = $this->getSvgTempPath().DIRECTORY_SEPARATOR.$iconSetName;

        /**
         * @var SplFileInfo $iconFile
         */
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
}

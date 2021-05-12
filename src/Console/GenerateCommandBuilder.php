<?php

namespace BladeUI\Icons\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

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
    private ?\Closure $svgNormalizationClosure = null;

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

    public function withSvgNormalisation(\Closure $svgNormalizationClosure): self
    {
        $this->svgNormalizationClosure = $svgNormalizationClosure;
        return $this;
    }

    public function run()
    {
        return (new SingleCommandApplication())
            ->setName('My Super Command') // Optional
            ->setVersion('1.0.0') // Optional
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $output->writeln("Starting build process for {$this->name} icon pack.");
                if (!is_dir($this->getSvgSourcePath())) {
                    $output->writeln("The SVG source folder does not exist yet - check: <{$this->getSvgSourcePath()}>");
                    return Command::FAILURE;
                }
                $tempDirPath = $this->getSvgTempPath();
                $this->ensureDirExists($tempDirPath);

                $output->writeln("Discovering source SVGs for icon sets...");
                foreach ($this->iconSets as $iconSet => $prefix) {
                    $output->writeln("Processing '{$iconSet}' icon set SVGs.");
                    // Setup build dir for type
                    $iconSetTmpDir = sprintf('%s/%s', $tempDirPath, $iconSet);
                    $this->ensureDirExists($iconSetTmpDir);

                    $fileTransformationList = $this->getDirectoryFileList($this->getSvgSourcePath() . '/' . $iconSet, $prefix);
                    $this->updateSvgs($iconSet, $fileTransformationList);
                    $output->writeln("Completed processing for '{$iconSet}' svgs.");
                }

                $output->writeln("Cleaning up the build directory...");
                $this->deleteDirectory(static::getSvgTempPath());
                $output->writeln("Done!");

                return Command::SUCCESS;
            })
            ->run();
    }

    private function getSvgSourcePath(): string
    {
        if ($this->npmPackageName !== null) {
            return sprintf(
                '%s/node_modules/%s/%s',
                $this->baseDirectory,
                $this->npmPackageName,
                ltrim($this->sourceDirectory, DIRECTORY_SEPARATOR)
            );
        }

        return sprintf(
            '%s/%s',
            $this->baseDirectory,
            ltrim($this->sourceDirectory, DIRECTORY_SEPARATOR)
        );
    }

    private function getSvgTempPath(): string
    {
        return $this->baseDirectory . '/build';
    }

    private function getSvgDestinationPath(): string
    {
        return $this->baseDirectory . '/resources/svg';
    }

    private function ensureDirExists($dirPath)
    {
        if (!is_dir($dirPath)) {
            if (!mkdir($dirPath) && !is_dir($dirPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dirPath));
            }
        }
    }

    /**
     * @param string $dirPath
     *
     * @return array<array<string>>
     */
    private function getDirectoryFileList(string $dirPath, string $prefix): array
    {
        // Scan for files...
        $filesList = scandir($dirPath);
        // Filter out the "." and ".." items.
        $filesList = array_diff($filesList, ['..', '.']);

        // modify things to a tuple:
        $filesList = collect($filesList)
            ->map(static fn($value) => [$value, Str::after($value, $prefix)]);

        return $filesList->values()->toArray();
    }

    public function updateSvgs(string $iconSet, array $fileTransformations): void
    {
        $iconSetTmpDir = $this->getSvgTempPath() . DIRECTORY_SEPARATOR . $iconSet;

        foreach ($fileTransformations as $fileTransformation) {
            [$orgFile, $newFile] = $fileTransformation;
            // Set path variables...
            $sourceFile = $this->getSvgSourcePath() . DIRECTORY_SEPARATOR . $iconSet . DIRECTORY_SEPARATOR . $orgFile;
            $tempFile = $iconSetTmpDir . DIRECTORY_SEPARATOR . $newFile;
            $finalFile = $this->getSvgDestinationPath() . DIRECTORY_SEPARATOR . $iconSet . DIRECTORY_SEPARATOR . $newFile;

            // Copy file to temp...
            copy($sourceFile, $tempFile);

            // Apply user transformations if they provide them...
            if ($this->svgNormalizationClosure !== null) {
                $normalizeSvgClosure = $this->svgNormalizationClosure;
                $normalizeSvgClosure($tempFile, $iconSet);
            }

            // Copy to final destination...
            copy($tempFile, $finalFile);
        }
    }

    private function deleteDirectory(string $directory) {
        $files = array_diff(scandir($directory), array('.','..'));
        foreach ($files as $file) {
            $path = $directory . DIRECTORY_SEPARATOR . $file;
            (is_dir($path)) ? $this->deleteDirectory($path) : unlink($path);
        }
        return rmdir($directory);
    }
}
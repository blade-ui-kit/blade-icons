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
    private bool $useSingleIconSet = false;

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

    public function useSingleIconSet(): self
    {
        $this->useSingleIconSet = true;
        return $this;
    }

    public function run()
    {
        return (new SingleCommandApplication())
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $output->writeln("Starting build process for {$this->name} icon pack.");
                if (!is_dir($this->getSvgSourcePath())) {
                    $output->writeln("The SVG source folder does not exist yet - check: <{$this->getSvgSourcePath()}>");
                    return Command::FAILURE;
                }
                $tempDirPath = $this->getSvgTempPath();
                $this->ensureDirExists($tempDirPath);

                $output->writeln("Discovering source SVGs for icon sets...");
                foreach ($this->iconSets as $iconSetConfig) {
                    /**
                     * @var IconSetConfig $iconSetConfig
                     */
                    $iconSetConfig->setSourcePath($this->getSvgSourcePath())
                                ->setTempPath($this->getSvgTempPath())
                                ->setDestinationPath($this->getSvgDestinationPath());
                    $iconSetName = $iconSetConfig->name;
                    $output->writeln("Processing '{$iconSetName}' icon set SVGs.");
                    // Setup build dir for type
                    $iconSetTmpDir = sprintf('%s/%s', $tempDirPath, $iconSetName);
                    $this->ensureDirExists($iconSetTmpDir);

                    $iconFileList = $this->getDirectoryFileList($this->getSvgSourcePath() . '/' . $iconSetName, $iconSetConfig);
                    $this->updateSvgs($iconSetConfig, $iconFileList);
                    $output->writeln("Completed processing for '{$iconSetName}' svgs.");
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
    private function getDirectoryFileList(string $dirPath, IconSetConfig $iconSetConfig): array
    {
        return array_diff(scandir($dirPath), ['..', '.']);
    }

    public function updateSvgs(IconSetConfig $iconSet, array $iconFileList): void
    {

        $iconSetName = $iconSet->name;
        $iconSetTmpDir = $this->getSvgTempPath() . DIRECTORY_SEPARATOR . $iconSetName;

        foreach ($iconFileList as $iconFile) {
            // Set path variables...
            $sourceFile = $iconSet->getSourceFilePath($iconFile);
            $tempFile = $iconSet->getTempFilePath($iconFile);
            $finalFile = $iconSet->getDestinationFilePath($iconFile, $this->useSingleIconSet);

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
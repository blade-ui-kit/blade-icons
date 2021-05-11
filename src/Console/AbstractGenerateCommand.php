<?php

namespace BladeUI\Icons\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractGenerateCommand extends Command
{
    protected static string $npmPackage; // Should be set by implementing command...
    protected static string $sourceSvgFolder = '/svg';

    /**
     * @var array{string, string}
     */
    protected static array $iconSets; // Should be set by implementing command...

    /**
     * @var string|null The default command name
     */
    protected static string $baseDir;

    const TMP_DEST_BASE = '/build';
    const SVG_DEST_BASE = '/resources/svg';


    public function __construct(string $name = null)
    {
        $childClassReflection = new \ReflectionClass(static::class);
        static::$baseDir = dirname($childClassReflection->getFileName(), 3);
        parent::__construct($name);
    }

    protected static function getSvgSourcePath(): string
    {
        return static::$baseDir . '/node_modules/' . static::$npmPackage . static::$sourceSvgFolder;
    }

    protected static function getSvgTempPath(): string
    {
        return static::$baseDir . static::TMP_DEST_BASE;
    }

    protected static function getSvgDestinationPath(): string
    {
        return static::$baseDir . static::SVG_DEST_BASE;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!is_dir(static::getSvgSourcePath())) {
            $output->writeln("The node_modules folder doesn't exist");
            return Command::FAILURE;
        }
        $this->ensureDirExists(static::getSvgTempPath());

        $output->writeln("Starting to discover source SVGs...");

        foreach (static::$iconSets as $iconSet => $prefix) {
            $output->writeln("Processing SVGs for {$iconSet} type svgs.");
            // Setup build dir for type
            $this->ensureDirExists(static::getSvgTempPath() . '/' . $iconSet);

            $fileTransformationList = $this->getDirectoryFileList(static::getSvgSourcePath() . '/' . $iconSet, $prefix);
            $this->updateSvgs($iconSet, $fileTransformationList);
            $output->writeln("Completed processing for {$iconSet} svgs.");
        }

        $output->writeln("Cleaning up the build directory...");
        $this->deleteDirectory(static::getSvgTempPath());
        $output->writeln("Done!");

        return Command::SUCCESS;
    }

    private function ensureDirExists(string $dirPath)
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

    private function deleteDirectory(string $directory) {
        $files = array_diff(scandir($directory), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$directory/$file")) ? $this->deleteDirectory("$directory/$file") : unlink("$directory/$file");
        }
        return rmdir($directory);
    }


    public function updateSvgs(string $iconSet, array $fileTransformations): void
    {
        $typeTempDir = static::getSvgTempPath() . '/'  . $iconSet;

        foreach ($fileTransformations as $fileTransformation) {
            [$orgFile, $newFile] = $fileTransformation;
            // Set path variables...
            $sourceFile = static::getSvgSourcePath() . '/' . $iconSet . '/' . $orgFile;
            $tempFile = $typeTempDir . '/' . $newFile;
            $finalFile = sprintf('%s/%s/%s', static::getSvgDestinationPath(), $iconSet, $newFile);

            // Copy file to temp...
            copy($sourceFile, $tempFile); // Stage 1
            $this->normalizeSvgFile($tempFile, $iconSet); // Stage 2

            // Final stage...
            copy($tempFile, $finalFile);
        }
    }

    /**
     * This method should be used to normalize SVGs to prepare them for blade-icons.
     *
     * This is fired after copying the SVG to a temp folder, but before putting them in their final place.
     * Any changes to the file should be made in place; so no changes should result in a new file being made.
     *
     * @param string $tempFilepath
     * @param string $iconSet
     */
    abstract public function normalizeSvgFile(string $tempFilepath, string $iconSet): void;
}
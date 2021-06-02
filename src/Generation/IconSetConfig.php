<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

use Illuminate\Support\Str;

final class IconSetConfig
{
    public string $set;

    public string $inputFilePrefix = '';

    public string $outputFilePrefix = '';

    private string $svgTempPath;

    private string $svgDestinationPath;

    private function __construct(string $set)
    {
        $this->set = $set;
    }

    public static function create(string $set): self
    {
        return new self($set);
    }

    public function setInputFilePrefix(string $filePrefix): self
    {
        $this->inputFilePrefix = $filePrefix;

        return $this;
    }

    public function setOutputFilePrefix(string $filePrefix): self
    {
        $this->outputFilePrefix = $filePrefix;

        return $this;
    }

    public function setTempPath(string $svgTempPath): self
    {
        $this->svgTempPath = $svgTempPath;

        return $this;
    }

    public function getTempFilePath(string $iconFileName): string
    {
        return $this->svgTempPath.DIRECTORY_SEPARATOR.$this->set.DIRECTORY_SEPARATOR.$iconFileName;
    }

    public function setDestinationPath(string $svgDestinationPath): self
    {
        $this->svgDestinationPath = $svgDestinationPath;

        return $this;
    }

    public function getDestinationFilePath(string $iconFileName, bool $singleIconSet = false): string
    {
        $destinationFilePath = $this->svgDestinationPath.DIRECTORY_SEPARATOR;

        if ($singleIconSet) {
            return $this->compileDestinationFileName($destinationFilePath, $iconFileName);
        }

        // Concat the set name onto the path...
        $destinationFilePath .= $this->set.DIRECTORY_SEPARATOR;

        return $this->compileDestinationFileName($destinationFilePath, $iconFileName);
    }

    private function compileDestinationFileName(string $basePath, string $iconFileName): string
    {
        if ($this->inputFilePrefix !== '' && $this->outputFilePrefix !== '') {
            return $basePath.Str::of($iconFileName)->after($this->inputFilePrefix)->prepend($this->outputFilePrefix);
        }

        if ($this->inputFilePrefix !== '') {
            return $basePath.Str::of($iconFileName)->after($this->inputFilePrefix);
        }

        if ($this->outputFilePrefix !== '') {
            return $basePath.Str::of($iconFileName)->prepend($this->outputFilePrefix);
        }

        return $basePath.$iconFileName;
    }
}

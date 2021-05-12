<?php

namespace BladeUI\Icons\Console;

use Illuminate\Support\Str;

class IconSetConfig
{
    public string $name;
    public string $iconSetPrefix = '';
    public string $inputFilePrefix = '';
    public string $outputFilePrefix = '';
    private string $svgSourcePath;
    private string $svgTempPath;
    private string $svgDestinationPath;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function setIconSetPrefix(string $prefix): self
    {
        $this->iconSetPrefix = $prefix;
        return $this;
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

    public function setSourcePath(string $svgSourcePath): self
    {
        $this->svgSourcePath = $svgSourcePath;
        return $this;
    }

    public function getSourceFilePath(string $iconFileName): string
    {
        return $this->svgSourcePath . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . $iconFileName;
    }

    public function setTempPath(string $svgTempPath): self
    {
        $this->svgTempPath = $svgTempPath;
        return $this;
    }

    public function getTempFilePath(string $iconFileName): string
    {
        return $this->svgTempPath . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . $iconFileName;
    }

    public function setDestinationPath(string $svgDestinationPath): self
    {
        $this->svgDestinationPath = $svgDestinationPath;
        return $this;
    }

    public function getDestinationFilePath(string $iconFileName, bool $singleIconSet = false): string
    {
        if ($singleIconSet) {
            if ($this->outputFilePrefix !== '') {
                return $this->svgDestinationPath . DIRECTORY_SEPARATOR . Str::of($iconFileName)->prepend($this->outputFilePrefix);
            }
            return $this->svgDestinationPath . DIRECTORY_SEPARATOR . $iconFileName;
        }

        if ($this->inputFilePrefix !== '') {
            return $this->svgDestinationPath . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . Str::of($iconFileName)->after($this->inputFilePrefix);
        }
        return $this->svgDestinationPath . DIRECTORY_SEPARATOR . $this->name . DIRECTORY_SEPARATOR . $iconFileName;
    }
}
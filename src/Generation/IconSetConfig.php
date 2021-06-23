<?php

declare(strict_types=1);

namespace BladeUI\Icons\Generation;

final class IconSetConfig
{
    public string $set;

    public string $inputFilePrefix = '';

    public string $outputFilePrefix = '';

    public string $svgDestinationPath;

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

    public function setDestinationPath(string $svgDestinationPath): self
    {
        $this->svgDestinationPath = $svgDestinationPath;

        return $this;
    }
}

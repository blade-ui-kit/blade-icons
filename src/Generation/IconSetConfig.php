<?php

namespace BladeUI\Icons\Generation;

use Closure;
use SplFileInfo;

class IconSetConfig
{
    public string $source;

    public string $destination;

    public string $inputPrefix;

    public string $outputPrefix;

    public string $inputSuffix;

    public string $outputSuffix;

    public bool $safe;

    /**
     * @var ?Closure(string, IconSetConfig, SplFileInfo): void
     */
    public ?Closure $after;

    private function __construct(
        string $source,
        string $destination,
        string $inputPrefix,
        string $outputPrefix,
        string $inputSuffix,
        string $outputSuffix,
        bool $safe,
        ?Closure $after
    ) {
        $this->source = $source;
        $this->destination = $destination;
        $this->inputPrefix = $inputPrefix;
        $this->outputPrefix = $outputPrefix;
        $this->inputSuffix = $inputSuffix;
        $this->outputSuffix = $outputSuffix;
        $this->safe = $safe;
        $this->after = $after;
    }

    /**
     * @param string $source Define a source directory for the icon sets. Like a node_modules/ or vendor/ directory.
     * @param string $destination Define a destination directory for your icons.
     * @param string $inputPrefix Strip an optional prefix from each source icon name.
     * @param string $outputPrefix Set an optional prefix to applied to each destination icon name.
     * @param string $inputSuffix Strip an optional suffix from each source icon name.
     * @param string $outputSuffix Set an optional suffix to applied to each destination icon name.
     * @param bool|null $safe Enable "safe" mode which will prevent deletion of old icons.
     * @param Closure(string, IconSetConfig, SplFileInfo): void|null $after Call an optional callback to manipulate the icon.
     * @return static
     */
    public static function build(
        string $source,
        string $destination,
        string $inputPrefix = '',
        string $outputPrefix = '',
        string $inputSuffix = '',
        string $outputSuffix = '',
        ?bool $safe = false,
        ?Closure $after = null
    ): self
    {
        return new self(
            $source,
            $destination,
            $inputPrefix,
            $outputPrefix,
            $inputSuffix,
            $outputSuffix,
            $safe,
            $after,
        );
    }

    public static function tryFromArray(array $config) : self
    {
        if (!isset($config['source'], $config['destination'])) {
            throw new \RuntimeException('Config must have source and destination set');
        }

        return self::build(
            $config['source'],
            $config['destination'],
            $config['input-prefix'] ?? '',
            $config['output-prefix'] ?? '',
            $config['input-suffix'] ?? '',
            $config['output-suffix'] ?? '',
            $config['safe'] ?? false,
            $config['after'] ?? null,
        );
    }
}
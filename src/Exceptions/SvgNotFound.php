<?php

declare(strict_types=1);

namespace BladeUI\Icons\Exceptions;

use Exception;

final class SvgNotFound extends Exception
{
    public static function missing(string $set, string $name)
    {
        return new static("Svg by name \"$name\" from set \"$set\" not found.");
    }
}

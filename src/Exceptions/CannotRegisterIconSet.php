<?php

declare(strict_types=1);

namespace BladeUI\Icons\Exceptions;

use Exception;

final class CannotRegisterIconSet extends Exception
{
    public static function pathsNotDefined(string $set): self
    {
        return new self("The options for the \"$set\" set don't have any paths defined.");
    }

    public static function nonExistingPath(string $set, string $path): self
    {
        return new self("The [$path] path for the \"$set\" set does not exist.");
    }

    public static function prefixNotDefined(string $set): self
    {
        return new self("The options for the \"$set\" set don't have a prefix defined.");
    }

    public static function prefixNotUnique(string $set, string $collidingSet): self
    {
        return new self("The prefix for the \"$set\" collides with the one from the \"$collidingSet\" set.");
    }
}

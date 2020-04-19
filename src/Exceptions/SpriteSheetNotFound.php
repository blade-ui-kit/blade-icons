<?php

declare(strict_types=1);

namespace BladeUI\Icons\Exceptions;

use Exception;

final class SpriteSheetNotFound extends Exception
{
    public static function missing(string $set)
    {
        return new static("SpriteSheet for set \"$set\" not found.");
    }
}

<?php

declare(strict_types=1);

namespace BladeUI\Icons\Exceptions;

use Exception;

final class SpriteUrlNotFound extends Exception
{
    public static function missing(string $set)
    {
        return new static("Sprite url for set \"$set\" not found.");
    }
}

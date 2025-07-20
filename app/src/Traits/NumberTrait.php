<?php

namespace App\Traits;

trait NumberTrait
{


    protected function __toInteger(mixed $value): int
    {
        if (is_bool($value)) {
            return $value ? 1 : 0;
        } elseif (is_numeric($value)) {
            return (int)$value;
        } elseif (is_string($value)) {
            return (int)$value;
        }
        return 0;
    }

    protected function __toFloat(mixed $value): float
    {
        if (is_bool($value)) {
            return $value ? 1 : 0;
        } elseif (is_numeric($value)) {
            return (float)$value;
        } elseif (is_string($value)) {
            return (float)$value;
        }
        return 0;
    }
}
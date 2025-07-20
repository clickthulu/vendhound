<?php

namespace App\Traits;

trait BooleanTrait
{

    protected function __toBoolean(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        } elseif (is_int($value)) {
            return $value > 0;
        } elseif (is_string($value) && ($value === '1' || strtoupper(substr($value,0,1)) === 'T' || strtoupper(substr($value,0,1)) === 'Y' )) {
            return true;
        }
        return false;
    }


}
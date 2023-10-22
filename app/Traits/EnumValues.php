<?php

namespace App\Traits;

trait EnumValues
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function defaultValue(): string
    {
        return array_column(self::cases(), 'value')[0];
    }

}

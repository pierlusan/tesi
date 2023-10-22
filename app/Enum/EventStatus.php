<?php

namespace App\Enum;
use App\Traits\EnumValues;
use App\Traits\EnumOptions;


enum EventStatus:string
{
    use EnumValues;
    use EnumOptions;

    case PLANNED = 'planned';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';


    public function isPlanned(): bool
    {
        return $this === self::PLANNED;
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function isCanceled(): bool
    {
        return $this === self::CANCELED;
    }

}

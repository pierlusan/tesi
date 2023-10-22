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
    
}

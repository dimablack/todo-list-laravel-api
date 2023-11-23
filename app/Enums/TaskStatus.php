<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum TaskStatus: int
{
    use EnumToArray;

    case TODO = 1;
    case DONE = 2;
}

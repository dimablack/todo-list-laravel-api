<?php

namespace App\Enums;

use App\Traits\EnumToArrayTrait;

enum TaskStatus: int
{
    use EnumToArrayTrait;

    case TODO = 1;
    case DONE = 2;
}

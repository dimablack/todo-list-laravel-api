<?php

namespace App\DTOs\RequestDTO;

use Spatie\LaravelData\Data;

class SortTaskDTO extends Data
{
    public ?string $field;

    public ?string $direct;
}

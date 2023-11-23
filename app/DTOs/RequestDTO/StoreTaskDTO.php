<?php

namespace App\DTOs\RequestDTO;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class StoreTaskDTO extends Data
{
    #[MapName('parent_id')]
    public ?string $parentId = null;

    public int $priority;

    public string $title;

    public ?string $description = null;
}

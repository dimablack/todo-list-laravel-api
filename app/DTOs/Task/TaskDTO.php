<?php

namespace App\DTOs\Task;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class TaskDTO extends TaskBaseDTO
{
    public ?string $description = null;

    #[DataCollectionOf(self::class)]
    public DataCollection $children;
}

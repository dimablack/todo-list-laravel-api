<?php

namespace App\DTOs\Task;

use DateTime;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class TaskBaseDTO extends Data
{
    public string $id;

    #[MapName('parent_id')]
    public ?string $parentId = null;

    public int $status;

    #[MapName('status_name')]
    public string $statusName;

    public int $priority;

    public string $title;

    #[MapName('created_at')]
    public DateTime $createdAt;

    #[MapName('completed_at')]
    public ?DateTime $completedAt = null;

    #[DataCollectionOf(self::class)]
    public DataCollection $children;
}

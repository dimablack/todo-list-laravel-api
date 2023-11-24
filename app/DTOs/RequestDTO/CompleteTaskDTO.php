<?php

namespace App\DTOs\RequestDTO;

use App\Enums\TaskStatus;
use Carbon\Carbon;
use DateTime;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class CompleteTaskDTO extends Data
{
    #[Computed]
    public int $status;

    #[Computed]
    #[MapName('completed_at')]
    public ?DateTime $completedAt;

    public function __construct()
    {
        $this->status = TaskStatus::DONE->value;
        $this->completedAt = Carbon::now();
    }
}

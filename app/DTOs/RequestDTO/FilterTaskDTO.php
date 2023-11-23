<?php

namespace App\DTOs\RequestDTO;

use Spatie\LaravelData\Data;

class FilterTaskDTO extends Data
{
    public ?int $status;

    public ?int $priority;

    public ?string $search;

    public array $sortItems;

    public function __construct(array $sort = [])
    {
        $this->initializeSortItems($sort);
    }

    /**
     * Initializes the $sortItems array with SortTaskDTO objects.
     *
     * @param array $sort An array of sorting parameters.
     */
    private function initializeSortItems(array $sort): void
    {
        $this->sortItems = array_map(
            fn ($sortItem) => SortTaskDTO::from($sortItem),
            $sort
        );
    }
}

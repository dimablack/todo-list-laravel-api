<?php

namespace App\Services\Contracts;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\DTOs\RequestDTO\StoreTaskDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

interface TaskServiceInterface
{
    /**
     * Get all tasks based on the provided filters for a specific user.
     *
     * @param FilterTaskDTO $filterTaskData
     * @param User $user
     *
     * @return Builder
     */
    public function getAll(FilterTaskDTO $filterTaskData, User $user): Builder;

    /**
     * Create a new task using the provided data and associate it with a user.
     *
     * @param StoreTaskDTO $taskData
     * @param User $user
     *
     * @return Task
     */
    public function create(StoreTaskDTO $taskData, User $user): Task;

    /**
     * Update a task using the provided data.
     *
     * @param Data $taskData
     * @param Task $task
     * @return Task
     */
    public function update(Data $taskData, Task $task): Task;
}

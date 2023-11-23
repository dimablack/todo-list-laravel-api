<?php

namespace App\Repositories;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface ITaskRepository
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
     * Create a new task in the repository.
     *
     * @param Task $task
     *
     * @return Task
     */
    public function create(Task $task): Task;
}

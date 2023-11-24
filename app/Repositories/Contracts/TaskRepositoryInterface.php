<?php

namespace App\Repositories\Contracts;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface TaskRepositoryInterface
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
     * Save a task in the database.
     *
     * @param Task $task
     *
     * @return Task
     */
    public function save(Task $task): Task;
}

<?php

namespace App\Services\Contracts;

use App\Models\Task;
use App\Models\User;

interface TaskPolicyServiceInterface
{
    /**
     * Check if the user can create a task.
     *
     * @param User $user
     * @param string|null $parentTaskId
     * @return bool
     */
    public function canCreateTask(User $user, ?string $parentTaskId): bool;

    /**
     * Check if the user belongs to the task.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function userBelongsToTask(User $user, Task $task): bool;

    /**
     * Check if the task is completed.
     *
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function completedTask(User $user, Task $task): bool;

    /**
     * Check if the task has not completed children(sub-tasks).
     *
     * @param Task $task
     * @return bool
     */
    public function hasNotCompletedChildren(Task $task): bool;
}

<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Services\Contracts\TaskPolicyServiceInterface;

class TaskPolicyService implements TaskPolicyServiceInterface
{
    /**
     * @inheritDoc
     */
    public function canCreateTask(User $user, ?string $parentTaskId): bool
    {
        return $parentTaskId === null || $user->tasks()->where('id', $parentTaskId)->exists();
    }

    /**
     * @inheritDoc
     */
    public function userBelongsToTask(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * @inheritDoc
     */
    public function completedTask(User $user, Task $task): bool
    {
        return TaskStatus::DONE->value === $task->status->value;
    }

    /**
     * @inheritDoc
     */
    public function hasNotCompletedChildren(Task $task): bool
    {
        return $task->checkIfExistNotCompletedInChildren();
    }
}

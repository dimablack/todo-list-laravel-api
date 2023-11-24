<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Services\Contracts\TaskPolicyServiceInterface;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function __construct(private readonly TaskPolicyServiceInterface $taskPolicyService)
    {
    }

    /**
     * Determine whether the user can create Task models.
     *
     * @param User $user
     * @param mixed $parentTaskId
     *
     * @return Response
     */
    public function create(User $user, string|null $parentTaskId): Response
    {
        return $this->taskPolicyService->canCreateTask($user, $parentTaskId)
            ? Response::allow()
            : $this->denyNotBelongs();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Task $task
     *
     * @return Response
     */
    public function update(User $user, Task $task): Response
    {
        return $this->taskPolicyService->userBelongsToTask($user, $task)
            ? Response::allow()
            : $this->denyNotBelongs();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Task $task
     *
     * @return Response
     */
    public function delete(User $user, Task $task): Response
    {
        if (!$this->taskPolicyService->userBelongsToTask($user, $task)) {
            return $this->denyNotBelongs();
        }

        if ($this->taskPolicyService->completedTask($user, $task)) {
            return $this->denyCompletedTask();
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can complete the model.
     *
     * @param User $user
     * @param Task $task
     *
     * @return Response
     */
    public function complete(User $user, Task $task): Response
    {
        if (!$this->taskPolicyService->userBelongsToTask($user, $task)) {
            return $this->denyNotBelongs();
        }

        if ($this->taskPolicyService->completedTask($user, $task)) {
            return $this->denyCompletedTask();
        }
        $t = $this->taskPolicyService->hasNotCompletedChildren($task);
        if ($this->taskPolicyService->hasNotCompletedChildren($task)) {
            return $this->denyNotCompletedChildren();
        }

        return Response::allow();
    }

    /**
     * Deny access due to not belonging to the task.
     *
     * @return Response
     */
    private function denyNotBelongs(): Response
    {
        return Response::deny(__('api.auth.not_belongs', ['object' => __('names.task.parent_task')]), 403);
    }

    /**
     * Deny access due to a completed task.
     *
     * @return Response
     */
    private function denyCompletedTask(): Response
    {
        return Response::deny(__('api.message.deny.status.completed', ['object' => __('names.task.model')]), 403);
    }

    /**
     * Deny access due to not having completed children.
     *
     * @return Response
     */
    private function denyNotCompletedChildren(): Response
    {
        return Response::deny(__('api.message.deny.status.not_completed_children'), 403);
    }
}

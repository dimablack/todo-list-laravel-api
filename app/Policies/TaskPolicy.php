<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can create Task models.
     */
    public function create(User $user, $parentTaskId): Response
    {
        return ($parentTaskId === null || ($user->tasks()->where('id', $parentTaskId)->exists())
            ? Response::allow()
            : Response::deny(
                __('api.auth.notBelongs', ['object' => __('names.task.parent_task')]),
                403
            ));
    }
}

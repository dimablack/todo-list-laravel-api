<?php

namespace App\Repositories;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements ITaskRepository
{
    /**
     * @inheritDoc
     */
    public function getAll(FilterTaskDTO $filterTaskData, User $user): Builder
    {
        return $user->tasks()->getQuery()
            ->filterByFields($filterTaskData)
            ->fullTextSearch($filterTaskData)
            ->sortByFields($filterTaskData);
    }

    /**
     * @inheritDoc
     */
    public function create(Task $task): Task
    {
        $task->save();
        return $task->fresh();
    }
}

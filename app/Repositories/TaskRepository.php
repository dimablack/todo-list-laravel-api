<?php

namespace App\Repositories;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAll(FilterTaskDTO $filterTaskData, User $user): Builder
    {
        return $user->tasks()
            ->whereNull('parent_id')
            ->with('children')
            ->getQuery()
            ->filterByFields($filterTaskData)
            ->fullTextSearch($filterTaskData)
            ->sortByFields($filterTaskData);
    }

    /**
     * @inheritDoc
     */
    public function save(Task $task): Task
    {
        $task->save();
        $task->load('children');
        return $task->refresh();
    }
}

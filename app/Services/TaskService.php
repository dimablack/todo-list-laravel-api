<?php

namespace App\Services;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\DTOs\RequestDTO\StoreTaskDTO;
use App\Models\Task;
use App\Models\User;
use App\Repositories\ITaskRepository;
use Illuminate\Database\Eloquent\Builder;

class TaskService implements ITaskService
{
    public function __construct(private readonly ITaskRepository $taskRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function getAll(FilterTaskDTO $filterTaskData, User $user): Builder
    {
        return $this->taskRepository->getAll($filterTaskData, $user);
    }

    /**
     * @inheritDoc
     */
    public function create(StoreTaskDTO $taskData, User $user): Task
    {
        $task = new Task($taskData->all());
        $task->user()->associate($user);

        return $this->taskRepository->create($task);
    }
}

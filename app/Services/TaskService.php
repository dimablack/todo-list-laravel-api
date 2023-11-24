<?php

namespace App\Services;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\DTOs\RequestDTO\StoreTaskDTO;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Services\Contracts\TaskServiceInterface;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

class TaskService implements TaskServiceInterface
{
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
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

        return $this->taskRepository->save($task);
    }

    /**
     * @inheritDoc
     */
    public function update(Data $taskData, Task $task): Task
    {
        $task->fill($taskData->all());

        return $this->taskRepository->save($task);
    }
}

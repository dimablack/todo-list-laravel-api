<?php

namespace App\Http\Controllers\API\Task;

use App\DTOs\RequestDTO\FilterTaskDTO;
use App\DTOs\RequestDTO\StoreTaskDTO;
use App\DTOs\Task\TaskDTO;
use App\Http\Controllers\API\Abstracts\AbstractTaskController;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="user_id",
 *     name="user",
 *     in="path",
 *     description="ID of the user for whom the task is being created",
 *     required=true,
 *     example="9aa8bcd2-833c-4fef-bb0a-ab51967f925c",
 *     @OA\Schema(type="string")
 * )
 */
class UserTaskController extends AbstractTaskController
{
    /**
     * @OA\Get(
     *     path="/api/users/{user}/tasks",
     *     summary="Get a paginated list of tasks for a user",
     *     tags={"Task"},
     *     security={
     *         {"token": {}}
     *     },
     *     @OA\Parameter(ref="#/components/parameters/user_id"),
     *     @OA\Parameter(ref="#/components/parameters/status"),
     *     @OA\Parameter(ref="#/components/parameters/priority"),
     *     @OA\Parameter(ref="#/components/parameters/search"),
     *     @OA\Parameter(ref="#/components/parameters/sort[0][field]"),
     *     @OA\Parameter(ref="#/components/parameters/sort[0][direct]"),
     *     @OA\Parameter(ref="#/components/parameters/sort[1][field]"),
     *     @OA\Parameter(ref="#/components/parameters/sort[1][direct]"),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(ref="#/components/schemas/TaskCollection")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated access",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized access",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This action is unauthorized.")
     *         )
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Resource Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string",
     *                 example="No query results for model [User] 9aa8bcd2-833c-4fef-bb0a-ab51967f92c")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error response",
     *         @OA\JsonContent(ref="#/components/schemas/422")
     *     ),
     * )
     *
     * Display a listing of tasks for the given user.
     *
     * @param IndexTaskRequest $request The request object.
     * @param User $user The user whose tasks are to be displayed.
     *
     * @return TaskCollection Returns a collection of tasks.
     */
    public function index(IndexTaskRequest $request, User $user)
    {
        $requestData = FilterTaskDTO::from($request->validated());
        $tasks = $this->taskService->getAll($requestData, $user);
        $tasks = $tasks->paginate();

        return new TaskCollection($tasks);
    }

    /**
     * @OA\Post(
     *     path="/api/users/{user}/tasks",
     *     summary="Store a new Task",
     *     tags={"Task"},
     *     security={
     *         {"token": {}}
     *     },
     *     @OA\Parameter(ref="#/components/parameters/user_id"),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Create a new task for the specified user",
     *         @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful task creation",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated access",
     *         @OA\JsonContent(ref="#/components/schemas/401")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized access",
     *         @OA\JsonContent(ref="#/components/schemas/403")
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(ref="#/components/schemas/404")
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error response",
     *         @OA\JsonContent(ref="#/components/schemas/422")
     *     ),
     * )
     *
     * Store a newly created task for the given user.
     *
     * @param StoreTaskRequest $request The request object.
     * @param User $user The user for whom the task is created.
     *
     * @return TaskResource Returns the newly created task resource.
     */
    public function store(StoreTaskRequest $request, User $user)
    {
        $this->authorize('create', [Task::class, $request->input('parent_id')]);

        $taskData = StoreTaskDTO::from($request->validated());
        $task = $this->taskService->create($taskData, $user);
        $taskDTO = TaskDTO::from($task);

        return new TaskResource($taskDTO);
    }
}

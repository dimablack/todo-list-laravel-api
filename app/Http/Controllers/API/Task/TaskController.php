<?php

namespace App\Http\Controllers\API\Task;

use App\DTOs\RequestDTO\CompleteTaskDTO;
use App\DTOs\RequestDTO\UpdateTaskDTO;
use App\DTOs\Task\TaskDTO;
use App\Http\Controllers\API\Abstracts\AbstractTaskController;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Parameter(
 *     parameter="task_id",
 *     name="task",
 *     in="path",
 *     description="ID of the task to be updated",
 *     required=true,
 *     example="9aaaf739d-5aeb-4117-ab3a-829e635411172",
 *     @OA\Schema(type="string")
 * )
 */
class TaskController extends AbstractTaskController
{
    /**
     * @OA\Patch(
     *     path="/api/tasks/{task}",
     *     summary="Update a task",
     *     tags={"Task"},
     *     security={
     *         {"token": {}}
     *     },
     *     @OA\Parameter(
     *         ref="#/components/parameters/task_id"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Update a task",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful task update",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated access",
     *          @OA\JsonContent(ref="#/components/schemas/401")
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized access",
     *          @OA\JsonContent(ref="#/components/schemas/403")
     *      ),
     *      @OA\Response(
     *           response=404,
     *           description="Resource Not Found",
     *           @OA\JsonContent(ref="#/components/schemas/404")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error response",
     *          @OA\JsonContent(ref="#/components/schemas/422")
     *      ),
     * )
     *
     * Update a task.
     *
     * @param UpdateTaskRequest $request The request object.
     * @param Task $task The task to update.
     *
     * @return TaskResource Returns the updated task resource.
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $taskData = UpdateTaskDTO::from($request->validated());
        $task = $this->taskService->update($taskData, $task);
        $taskDTO = TaskDTO::from($task);

        return new TaskResource($taskDTO);
    }

    /**
     * @OA\Patch(
     *     path="/api/tasks/{task}/complete",
     *     summary="Mark a task as complete",
     *     tags={"Task"},
     *     security={
     *         {"token": {}}
     *     },
     *     @OA\Parameter(
     *         ref="#/components/parameters/task_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful task completion",
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
     *         response=404,
     *         description="Resource Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/404")
     *     ),
     * )
     *
     * Mark a task as complete.
     *
     * @param Task $task The task to complete.
     *
     * @return TaskResource Returns the completed task resource.
     */
    public function complete(Task $task): TaskResource
    {
        $this->authorize('complete', $task);

        $completeData = new CompleteTaskDTO();
        $task = $this->taskService->update($completeData, $task);
        $taskDTO = TaskDTO::from($task);

        return new TaskResource($taskDTO);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{task}",
     *     summary="Delete a task",
     *     tags={"Task"},
     *     security={
     *         {"token": {}}
     *     },
     *     @OA\Parameter(
     *         ref="#/components/parameters/task_id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful task deletion",
     *         @OA\JsonContent(ref="#/components/schemas/JsonResponse")
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
     *         response=404,
     *         description="Resource Not Found",
     *         @OA\JsonContent(ref="#/components/schemas/404")
     *     ),
     * )
     *
     * Delete a task.
     *
     * @param Task $task The task to delete.
     *
     * @return JsonResponse Returns a JSON response indicating the success of the deletion.
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return $this->responseMessage(__('api.crud.delete.success', ['object' => 'Task']));
    }
}

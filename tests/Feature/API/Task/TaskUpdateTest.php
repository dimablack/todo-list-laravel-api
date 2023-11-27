<?php

namespace Tests\Feature\API\Task;

use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskUpdateTest extends AbstractTaskClass
{
    use RefreshDatabase;

    private Task $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->create(['user_id' => $this->user->id]);
        $this->taskForSecondUser = Task::factory()->create(['user_id' => $this->secondUser->id]);
    }

    /**
     * Test successful response when updating a task.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::update()
     */
    public function testUpdateSuccessfulResponse(): void
    {
        // Valid data to update the task
        $data = [
            'priority' => 4,
            'title' => 'Updated Task Title',
            'description' => 'Updated Task Description',
        ];

        $response = $this->patchJson(route('tasks.update', $this->task->id), $data, $this->userHeaders);

        $response->assertOk()
            ->assertJsonStructure(['data' => ['id', 'title', 'priority', 'description']])
            ->assertJson(['data' => $data]);
    }

    /**
     * Test unauthorized access response when updating a task.
     *
     * @covers \App\Http\Requests\Task\UpdateTaskRequest::authorize()
     */
    public function testUpdateUnauthorizedAccessResponse(): void
    {
        $response = $this->patchJson(route('tasks.update', $this->taskForSecondUser->id), [], $this->userHeaders);

        $response->assertForbidden();
    }

    /**
     * Test resource not found response when updating a task with an invalid ID.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::update()
     */
    public function testUpdateResourceNotFoundResponse(): void
    {
        $response = $this->patchJson(route('tasks.update', 'wrong-task-id'), [], $this->userHeaders);

        $response->assertNotFound();
    }

    /**
     * Test unauthenticated access response when updating a task.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::update()
     */
    public function testUpdateUnauthenticatedAccessResponse(): void
    {
        $response = $this->patchJson(route('tasks.update', $this->task->id));

        $response->assertUnauthorized();
    }

    /**
     * Test validation of update request data.
     *
     * @covers \App\Http\Requests\Task\UpdateTaskRequest::rules()
     */
    public function testUpdateValidationRules()
    {
        // Test with invalid data
        $invalidData = [
            'priority' => 6, // Invalid priority
        ];

        $request = new UpdateTaskRequest($invalidData);

        $response = $this->patchJson(
            route('tasks.update', $this->task->id),
            $request->toArray(),
            $this->userHeaders
        );

        $response->assertUnprocessable()
            ->assertJsonStructure(['message', 'errors']);
    }
}

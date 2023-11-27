<?php

namespace Tests\Feature\API\Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskDeleteTest extends AbstractTaskClass
{
    use RefreshDatabase;

    private Task $task;

    /**
     * Set up the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->create(['user_id' => $this->user->id]);
        $this->taskForSecondUser = Task::factory()->create(['user_id' => $this->secondUser->id]);
    }

    /**
     * Test successful response when deleting a task.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::destroy()
     */
    public function testDeleteSuccessfulResponse(): void
    {
        $response = $this->deleteJson(route('tasks.destroy', $this->task->id), [], $this->userHeaders);

        $response->assertStatus(200);
    }

    /**
     * Test unauthorized access response when deleting a task.
     *
     * @covers \App\Policies\TaskPolicy::delete()
     */
    public function testDeleteUnauthorizedAccessResponse(): void
    {
        $response = $this->deleteJson(route('tasks.destroy', $this->taskForSecondUser->id), [], $this->userHeaders);

        $response->assertForbidden();
    }

    /**
     * Test resource not found response when deleting a task with an invalid ID.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::destroy()
     */
    public function testDeleteResourceNotFoundResponse(): void
    {
        $response = $this->deleteJson(route('tasks.destroy', 'wrong-task-id'), [], $this->userHeaders);

        $response->assertNotFound();
    }

    /**
     * Test unauthenticated access response when deleting a task.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::destroy()
     */
    public function testDeleteUnauthenticatedAccessResponse(): void
    {
        $response = $this->deleteJson(route('tasks.destroy', $this->task->id));

        $response->assertUnauthorized();
    }
}

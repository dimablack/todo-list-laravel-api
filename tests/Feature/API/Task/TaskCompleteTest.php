<?php

namespace Tests\Feature\API\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCompleteTest extends AbstractTaskClass
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
     * Test successful response when completing a task.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::complete()
     */
    public function testCompleteSuccessfulResponse(): void
    {
        $response = $this->patchJson(route('tasks.complete', $this->task->id), [], $this->userHeaders);

        $response->assertOk()
            ->assertJsonStructure(['data' => ['id', 'title', 'priority', 'completed_at']])
            ->assertJson(['data' => ['status' => TaskStatus::DONE->value]]);
    }

    /**
     * Test unauthorized access response when completing a task.
     *
     * @covers \App\Policies\TaskPolicy::complete()
     */
    public function testCompleteUnauthorizedAccessResponse(): void
    {
        $response = $this->patchJson(route('tasks.complete', $this->taskForSecondUser->id), [], $this->userHeaders);

        $response->assertForbidden();
    }

    /**
     * Test resource not found response when completing a task with an invalid ID.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::complete()
     */
    public function testCompleteResourceNotFoundResponse(): void
    {
        $response = $this->patchJson(route('tasks.complete', 'wrong-task-id'), [], $this->userHeaders);

        $response->assertNotFound();
    }

    /**
     * Test unauthenticated access response when completing a task.
     *
     * @covers \App\Http\Controllers\API\Task\TaskController::complete()
     */
    public function testCompleteUnauthenticatedAccessResponse(): void
    {
        $response = $this->patchJson(route('tasks.complete', $this->task->id));

        $response->assertUnauthorized();
    }
}

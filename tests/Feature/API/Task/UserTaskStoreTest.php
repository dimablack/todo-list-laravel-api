<?php

namespace Tests\Feature\API\Task;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class UserTaskStoreTest extends AbstractTaskClass
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Tests Successful task creation.
     *
     * @return void
     * @throws Throwable
     */
    public function testStoreSuccessfulResponse(): void
    {
        $data = [
            'parent_id' => null,
            'priority' => 3,
            'title' => 'Task Title',
            'description' => 'Task Description',
        ];

        $request = new StoreTaskRequest($data);

        $response = $this->postJson(
            route('users.tasks.store', $this->user->id),
            $request->toArray(),
            $this->userHeaders
        );

        $response->assertStatus(200);

        $taskId = $response->decodeResponseJson()['data']['id'];

        $task = Task::find($taskId);

        $this->assertNotNull($task);
        $this->assertEquals($data['priority'], $task->priority);
        $this->assertEquals($data['title'], $task->title);
        $this->assertEquals($data['description'], $task->description);
    }

    /**
     * Tests unauthorized access task creation.
     *
     * @return void
     * @throws Throwable
     */
    public function testStoreUnauthorizedAccessResponse(): void
    {
        $request = new StoreTaskRequest([]);

        $response = $this->postJson(
            route('users.tasks.store', $this->secondUser->id),
            $request->toArray(),
            $this->userHeaders
        );

        $response->assertForbidden();
    }

    /**
     * Tests validation error on task creation.
     *
     * @covers \App\Http\Requests\Task\StoreTaskRequest::rules()
     */
    public function testStoreValidationErrorResponse()
    {
        $data = [
            'parent_id' => 'invalid_uuid',
            'priority' => 6,
            'title' => '',
            'description' => null,
        ];

        $request = new StoreTaskRequest($data);

        $response = $this->postJson(
            route('users.tasks.store', $this->user->id),
            $request->toArray(),
            $this->userHeaders
        );

        $response->assertStatus(422);

        $errors = $response->decodeResponseJson()['errors'];

        $this->assertArrayHasKey('parent_id', $errors);
        $this->assertArrayHasKey('priority', $errors);
        $this->assertArrayHasKey('title', $errors);
    }
}

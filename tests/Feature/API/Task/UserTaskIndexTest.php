<?php

namespace Tests\Feature\API\Task;

use App\Http\Requests\Task\IndexTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTaskIndexTest extends AbstractTaskClass
{
    use RefreshDatabase;

    /**
     * Set up the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test successful response for the `index` method.
     *
     * @covers \App\Http\Controllers\API\Task\UserTaskController::index()
     */
    public function testIndexSuccessfulResponse()
    {
        $tasks = Task::factory(5)->create(['user_id' => $this->user->id]);

        $response = $this->getJson(route('users.tasks.index', ['user' => $this->user->id]), $this->userHeaders)
            ->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta']);

        $tasksCollection = $response->getOriginalContent()->toArray();
        $idsArray = array_column($tasksCollection, 'id');

        $collectionIds = $tasks->pluck('id')->toArray();

        $idsExistInCollection = empty(array_diff($idsArray, $collectionIds));

        $this->assertTrue($idsExistInCollection);
    }

    /**
     * Test unauthorized access response for the `index` method.
     *
     * @covers \App\Http\Controllers\API\Task\UserTaskController::index()
     */
    public function testIndexUnauthorizedAccessResponse()
    {
        Task::factory(5)->create(['user_id' => $this->secondUser->id]);

        $this->getJson(route('users.tasks.index', ['user' => $this->secondUser->id]), $this->userHeaders)
            ->assertForbidden();
    }

    /**
     * Test unauthorized access response for the `index` method with an invalid user.
     *
     * @return void
     */
    public function testUnauthorizedTaskIndex()
    {
        $this->getJson(route('users.tasks.index', ['user' => 'nonexistent-user']))
            ->assertUnauthorized()
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Test response for the `index` method with no tasks for the user.
     *
     * @covers \App\Http\Controllers\API\Task\UserTaskController::index()
     */
    public function testNoTasksForUser()
    {
        $response = $this->getJson(route('users.tasks.index', ['user' => $this->user->id]), $this->userHeaders)
            ->assertOk();

        $this->assertCount(0, $response->getOriginalContent()->toArray());
    }

    /**
     * Test unauthenticated access response for the `index` method
     *
     * @covers \App\Http\Controllers\API\Task\UserTaskController::index()
     */
    public function testIndexUnauthenticatedAccessResponse()
    {
        $this->getJson(route('users.tasks.index', ['user' => $this->user->id]))
            ->assertUnauthorized();
    }

    /**
     * Test validation rules for the `index` method
     *
     * @covers \App\Http\Requests\Task\IndexTaskRequest::rules()
     */
    public function testIndexValidationErrorResponse()
    {
        // Test with invalid data
        $invalidData = [
            'priority' => 6, // Invalid priority
            'status' => 3, //Invalid status
        ];

        $request = new IndexTaskRequest($invalidData);

        $this->json(
            'GET',
            route('users.tasks.index', ['user' => $this->user->id]),
            $request->toArray(),
            $this->userHeaders
        )
            ->assertUnprocessable();
    }
}

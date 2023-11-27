<?php

namespace Tests\Feature\API\Task;

use App\Models\User;
use Tests\TestCase;

abstract class AbstractTaskClass extends TestCase
{
    protected User $user;
    protected array $userHeaders;
    protected User $secondUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['email' => 'test1@example.com']);
        $this->userHeaders = $this->getHeadersWithToken();
        $this->secondUser = User::factory()->create(['email' => 'test2@example.com']);
    }

    private function getHeadersWithToken(): array
    {
        $token = $this->user->createToken('ApiToken')->plainTextToken;
        return ['Authorization' => 'Bearer ' . $token];
    }
}

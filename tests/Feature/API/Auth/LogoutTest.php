<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'test1@example.com',
            'password' => Hash::make('password')
        ]);
    }

    /**
     * Tests the logout controller response for a logged-in user.
     *
     * @covers \App\Http\Controllers\API\Auth\LogoutController::logout()
     */
    public function testSuccessfulLogout()
    {
        $token = $this->user->createToken('ApiToken')->plainTextToken;

        $tokenData = [
            'tokenable_type' => User::class,
            'tokenable_id' => $this->user->id
        ];

        $this->assertDatabaseHas('personal_access_tokens', $tokenData);

        $headers = ['Authorization' => 'Bearer ' . $token];

        $this->postJson(route('api.sanctum.logout'), [], $headers)
            ->assertOk();

        $this->assertDatabaseMissing('personal_access_tokens', $tokenData);
    }

    /**
     * Tests the logout controller response for an unauthorized user.
     *
     * @covers \App\Http\Controllers\API\Auth\LogoutController::logout()
     */
    public function testLogoutForUnauthorizedUser()
    {
        $this->postJson(route('api.sanctum.logout'))
            ->assertUnauthorized()
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}

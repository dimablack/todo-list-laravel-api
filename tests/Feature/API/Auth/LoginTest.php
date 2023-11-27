<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
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
     * Tests successful login with valid credentials.
     *
     * @covers \App\Http\Controllers\API\Auth\LoginController::login()
     */
    public function testLoginWithValidCredentials()
    {
        $request = [
            'email' => $this->user->email,
            'password' => 'password',
        ];

        $this->postJson(route('api.sanctum.token'), $request)
            ->assertOk()
            ->assertJsonStructure([
                'user' => [],
                'authorization' => [
                    'token',
                    'type',
                ],
            ]);

        $tokenData = [
            'tokenable_type' => User::class,
            'tokenable_id' => $this->user->id
        ];

        $this->assertDatabaseHas('personal_access_tokens', $tokenData);
    }

    /**
     * Tests failed login with invalid credentials.
     *
     * @covers \App\Http\Controllers\API\Auth\LoginController::login()
     */
    public function testLoginWithInvalidCredentials()
    {
        $invalidUserData = [
            'email' => 'test1@example.com',
            'password' => 'wrong_password',
        ];

        $this->postJson(route('api.sanctum.token'), $invalidUserData)
            ->assertUnauthorized();
    }

    /**
     * Tests validation of login request data.
     *
     * @covers \App\Http\Requests\Auth\LoginRequest::rules()
     * @dataProvider dataForInvalidLogin
     */
    public function testLoginValidationRules($email, $password)
    {
        $invalidUserData = ['email' => $email, 'password' => $password];

        $this->postJson(route('api.sanctum.token'), $invalidUserData)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                ],
            ]);
    }

    public static function dataForInvalidLogin(): array
    {
        return [
            ['invalid-email', ''],
            ['valid@example.com', ''],
            ['invalid-email', 'wrong_password'],
        ];
    }
}

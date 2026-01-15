<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use database\factories\UserFactory;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_fails_with_invalid_credentials()
    {
        // Arrange: Create a user with hashed password
        $user = User::factory()->create([
            'USE_MAIL' => 'test@example.com',
            'USE_PASSWORD' => Hash::make('password123'),
        ]);

        // Act & Assert: Wrong credentials
        $response = $this->postJson('/api/login', [
            'mail' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid credentials']);
    }

    public function test_login_returns_validation_error_for_missing_fields()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'mail',
                    'password'
                ]
            ]);
    }

    public function test_login_succeeds_with_valid_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'USE_MAIL' => 'test@example.com',
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_NAME' => 'John',
            'USE_LAST_NAME' => 'Doe',
        ]);

        // Act
        $response = $this->postJson('/api/login', [
            'mail' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Assert
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'user_id',
                    'user_name',
                    'user_last_name',
                    'user_mail',
                    'user_phone',
                    'user_birthdate',
                    'user_address',
                    'user_club',
                    'user_licence',
                    'user_pps',
                    'access_token',
                    'token_type'
                ]
            ])
            ->assertJson([
                'data' => [
                    'user_name' => 'John',
                    'user_last_name' => 'Doe',
                    'user_mail' => 'test@example.com',
                ]
            ]);
    }

    public function test_logout_fails_without_auth_token()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }

    public function test_logout_succeeds_with_valid_token()
    {
        $user = User::factory()->create([
            'USE_MAIL' => 'test@example.com',
            'USE_PASSWORD' => Hash::make('password123'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'mail' => 'test@example.com',
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logged out successfully']);

        // Verify tokens deleted from DB
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }




    public function test_register_fails_with_existing_email()
    {
        // Arrange: Create existing user
        User::factory()->create([
            'USE_MAIL' => 'test@example.com',
        ]);

        // Act & Assert
        $response = $this->postJson('/api/register', [
            'mail' => 'test@example.com',
            'password' => 'password123',
            'name' => 'John',
            'last_name' => 'Doe',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('errors.mail.0', 'The mail has already been taken.');
    }

    public function test_register_returns_validation_error_for_missing_fields()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'mail',
                    'password',
                    'name',
                    'last_name'
                ]
            ]);
    }

    public function test_register_succeeds_with_valid_data()
    {
        // Act
        $response = $this->postJson('/api/register', [
            'mail' => 'newuser@example.com',
            'password' => 'password12345678',
            'name' => 'Jane',
            'last_name' => 'Smith',
        ]);

        // Assert
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'user_id',
                    'user_name',
                    'user_last_name',
                    'user_mail',
                    'access_token',
                    'token_type'
                ]
            ]);

        // Verify user was created with hashed password
        $this->assertDatabaseHas('SAN_USERS', [
            'USE_MAIL' => 'newuser@example.com',
        ]);

        $user = User::where('USE_MAIL', 'newuser@example.com')->first();
        $this->assertTrue(Hash::check('password12345678', $user->USE_PASSWORD));
    }

    public function test_register_password_must_be_min_8_characters()
    {
        $response = $this->postJson('/api/register', [
            'mail' => 'test@example.com',
            'password' => 'short', // Less than 8 chars
            'name' => 'John',
            'last_name' => 'Doe',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('errors.password.0', 'The password field must be at least 8 characters.');
    }
}

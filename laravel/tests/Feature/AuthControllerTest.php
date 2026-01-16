<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use database\factories\UserFactory;
use Database\Seeders\InitialDatabaseSeeder;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialDatabaseSeeder::class);
    }

    public function test_login_fails_with_invalid_credentials()
    {
        // Arrange: Create a user with hashed password
        $user = User::factory()->create([
            'USE_MAIL' => 'test@orient.action.fr',
            'USE_PASSWORD' => Hash::make('password123'),
        ]);

        // Act & Assert: Wrong credentials
        $response = $this->postJson('/api/login', [
            'mail' => 'test@orient.action.fr',
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
        $user = User::where('USE_MAIL', 'admin.site@orient.action.fr')->first();

        // Act
        $response = $this->postJson('/api/login', [
            'mail' => 'admin.site@orient.action.fr',
            'password' => 'pwd123',
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
                    'access_token',
                    'token_type'
                ]
            ])
            ->assertJson([
                'data' => [
                    'user_name' => 'Admin',
                    'user_last_name' => 'Site',
                    'user_mail' => 'admin.site@orient.action.fr',
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
        $user = User::where('USE_MAIL', 'admin.site@orient.action.fr')->first();

        $loginResponse = $this->postJson('/api/login', [
            'mail' => 'admin.site@orient.action.fr',
            'password' => 'pwd123',
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
            'USE_MAIL' => 'test@orient.action.fr',
        ]);

        // Act & Assert
        $response = $this->postJson('/api/register', [
            'mail' => 'test@orient.action.fr',
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
            'mail' => 'newuser@orient.action.fr',
            'password' => 'password12345678',
            'name' => 'Jane',
            'last_name' => 'Smith',
            'gender' => 'Homme',
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
            'USE_MAIL' => 'newuser@orient.action.fr',
        ]);

        $user = User::where('USE_MAIL', 'newuser@orient.action.fr')->first();
        $this->assertTrue(Hash::check('password12345678', $user->USE_PASSWORD));
    }

    public function test_register_password_must_be_min_8_characters()
    {
        $response = $this->postJson('/api/register', [
            'mail' => 'test@orient.action.fr',
            'password' => 'short', // Less than 8 chars
            'name' => 'John',
            'last_name' => 'Doe',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('errors.password.0', 'The password field must be at least 8 characters.');
    }
}

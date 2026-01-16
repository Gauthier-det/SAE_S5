<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Club;
use App\Models\Address;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\InitialDatabaseSeeder;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialDatabaseSeeder::class);
        $this->admin = User::where('USE_MAIL', 'admin.site@orient.action.fr')->first();
        $this->user = User::factory()->create();
    }

    /**
     * Test get all users
     */
    public function test_get_all_users()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test get user by id
     */
    public function test_get_user_by_id()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson("/api/users/{$this->user->USE_ID}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }


    /**
     * Test check is admin
     */
    public function test_check_is_admin()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/user/is-admin');

        $response->assertStatus(200)
                 ->assertJson(['is_admin' => true]);
    }

    /**
     * Test update user
     */
    public function test_update_user()
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson("/api/users/{$this->user->USE_ID}", [
            'USE_NAME' => 'Updated Name',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('SAN_USERS', [
            'USE_ID' => $this->user->USE_ID,
            'USE_NAME' => 'Updated Name',
        ]);
    }

    /**
     * Test delete user
     */
    public function test_delete_user()
    {
        Sanctum::actingAs($this->admin);

        $testUser = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$testUser->USE_ID}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'User deleted successfully']);

        $this->assertDatabaseMissing('SAN_USERS', ['USE_ID' => $testUser->USE_ID]);
    }

    /**
     * Test get users by club
     */
    public function test_get_users_by_club()
    {
        $club = Club::first();

        $response = $this->getJson("/api/clubs/{$club->CLU_ID}/users");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test get free runners
     */
    public function test_get_free_runners()
    {
        $response = $this->getJson('/api/users/free');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test create user (admin)
     */
    public function test_create_user()
    {
        Sanctum::actingAs($this->admin);

        $address = Address::first();

        $response = $this->postJson('/api/users/1', [
            'USE_MAIL' => 'newuser@orient.action.fr',
            'USE_PASSWORD' => 'password123',
            'USE_NAME' => 'New',
            'USE_LAST_NAME' => 'User',
            'USE_GENDER' => 'Homme',
            'USE_MEMBERSHIP_DATE' => now()->format('Y-m-d'),
            'ADD_ID' => $address->ADD_ID,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('SAN_USERS', [
            'USE_MAIL' => 'newuser@orient.action.fr',
        ]);
    }

    /**
     * Test get user by id not found
     */
    public function test_get_user_by_id_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/users/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'User not found']);
    }

    /**
     * Test update user not found
     */
    public function test_update_user_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->putJson('/api/users/999', [
            'USE_NAME' => 'Updated',
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'User not found']);
    }

    /**
     * Test delete user not found
     */
    public function test_delete_user_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->deleteJson('/api/users/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'User not found']);
    }
}
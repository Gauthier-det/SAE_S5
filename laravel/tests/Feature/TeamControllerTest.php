<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_team_fails_without_authentication()
    {
        $response = $this->postJson('/api/teams', [
            'name' => 'Test Team',
        ]);

        $response->assertStatus(401);
    }

    public function test_create_team_returns_validation_error_for_missing_name()
    {
        $user = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/teams', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['name']
            ]);
    }

    public function test_authenticated_user_can_create_team()
    {
        $user = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/teams', [
            'name' => 'My Awesome Team',
            'image' => 'team-image.jpg',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'team_id',
                    'team_name',
                    'owner_id',
                    'message'
                ]
            ])
            ->assertJson([
                'data' => [
                    'team_name' => 'My Awesome Team',
                    'owner_id' => $user->USE_ID,
                ]
            ]);

        $this->assertDatabaseHas('SAN_TEAMS', [
            'USE_ID' => $user->USE_ID,
            'TEA_NAME' => 'My Awesome Team',
            'TEA_IMAGE' => 'team-image.jpg',
        ]);
    }

    public function test_add_member_fails_without_authentication()
    {
        $response = $this->postJson('/api/teams/addMember', [
            'user_id' => 1,
            'team_id' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_add_member_returns_validation_errors()
    {
        $user = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/teams/addMember', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'user_id',
                    'team_id',
                    'race_id'
                ]
            ]);
    }

    public function test_non_owner_cannot_add_member_to_team()
    {
        $this->seed(\Database\Seeders\InitialDatabaseSeeder::class);

        $owner = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_VALIDITY' => now()->addYear(),
        ]);
        $nonOwner = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_VALIDITY' => now()->addYear(),
        ]);
        $member = User::factory()->create();

        // Owner creates team
        $ownerResponse = $this->actingAs($owner)
            ->postJson('/api/teams', ['name' => 'Owner Team'])
            ->assertStatus(201)
            ->json('data.team_id');

        // Fresh test client for non-owner
        $nonOwnerTest = $this->actingAs($nonOwner);

        $response = $nonOwnerTest->postJson('/api/teams/addMember', [
            'user_id' => $member->USE_ID,
            'team_id' => $ownerResponse,
            'race_id' => 3,
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'Unauthorized - you did not create this team']);
    }

    public function test_cannot_add_same_user_twice_to_team()
    {
        $this->seed(\Database\Seeders\InitialDatabaseSeeder::class);

        $owner = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_VALIDITY' => now()->addYear(),
        ]);
        $member = User::factory()->create();

        // Owner creates team
        Sanctum::actingAs($owner);
        $teamResponse = $this->postJson('/api/teams', ['name' => 'Test Team']);
        $teamId = $teamResponse->json('data.team_id');

        // Add member first time (success)
        $response = $this->postJson('/api/teams/addMember', [
            'user_id' => $member->USE_ID,
            'team_id' => $teamId,
            'race_id' => 3,
        ]);
        $response->assertStatus(201);

        // Add same member again (conflict)
        $response = $this->postJson('/api/teams/addMember', [
            'user_id' => $member->USE_ID,
            'team_id' => $teamId,
            'race_id' => 3,
        ]);

        $response->assertStatus(409)
            ->assertJson(['message' => 'User is already part of the team']);

        $this->assertDatabaseHas('SAN_USERS_TEAMS', [
            'USE_ID' => $member->USE_ID,
            'TEA_ID' => $teamId,
        ]);
    }

    public function test_team_owner_can_add_member_to_their_team()
    {
        $this->seed(\Database\Seeders\InitialDatabaseSeeder::class);

        $owner = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_VALIDITY' => now()->addYear(),
        ]);
        $member = User::factory()->create();

        // Owner creates team
        Sanctum::actingAs($owner);
        $teamResponse = $this->postJson('/api/teams', ['name' => 'Test Team']);
        $teamId = $teamResponse->json('data.team_id');

        // Add member
        $response = $this->postJson('/api/teams/addMember', [
            'user_id' => $member->USE_ID,
            'team_id' => $teamId,
            'race_id' => 3, // Assuming race 3 exists from seed
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'team_id',
                    'user_id',
                    'message'
                ]
            ])
            ->assertJson([
                'data' => [
                    'team_id' => $teamId,
                    'user_id' => $member->USE_ID,
                ]
            ]);

        $this->assertDatabaseHas('SAN_USERS_TEAMS', [
            'USE_ID' => $member->USE_ID,
            'TEA_ID' => $teamId,
        ]);
    }

    public function test_get_team_by_id()
    {
        $owner = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_VALIDITY' => now()->addYear(),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'mail' => $owner->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams', ['name' => 'Test Team']);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/teams/1');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_users_by_team()
    {
        $owner = User::factory()->create([
            'USE_PASSWORD' => Hash::make('password123'),
            'USE_VALIDITY' => now()->addYear(),
        ]);
        $member = User::factory()->create();

        $loginResponse = $this->postJson('/api/login', [
            'mail' => $owner->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams', ['name' => 'Test Team']);

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams/addMember', [
                'user_id' => $member->USE_ID,
                'team_id' => 1,
            ]);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/teams/1/users');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

        $loginResponse = $this->postJson('/api/login', [
            'mail' => $user->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams', []);

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

        $loginResponse = $this->postJson('/api/login', [
            'mail' => $user->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams', [
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

        $loginResponse = $this->postJson('/api/login', [
            'mail' => $user->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams/addMember', []);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'user_id',
                    'team_id'
                ]
            ]);
    }

    public function test_non_owner_cannot_add_member_to_team()
    {
        $owner = User::factory()->create(['USE_PASSWORD' => Hash::make('password123')]);
        $nonOwner = User::factory()->create(['USE_PASSWORD' => Hash::make('password123')]);
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
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'Unauthorized - you did not create this team']);
    }

    public function test_cannot_add_same_user_twice_to_team()
    {
        $owner = User::factory()->create(['USE_PASSWORD' => Hash::make('password123')]);
        $member = User::factory()->create();

        // Owner login and create team
        $loginResponse = $this->postJson('/api/login', [
            'mail' => $owner->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams', ['name' => 'Test Team']);

        // Add member first time (success)
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams/addMember', [
                'user_id' => $member->USE_ID,
                'team_id' => 1,
            ]);
        $response->assertStatus(201);

        // Add same member again (conflict)
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams/addMember', [
                'user_id' => $member->USE_ID,
                'team_id' => 1,
            ]);

        $response->assertStatus(409)
            ->assertJson(['message' => 'User is already part of the team']);

        $this->assertDatabaseHas('SAN_USERS_TEAMS', [
            'USE_ID' => $member->USE_ID,
            'TEA_ID' => 1,
        ]);
    }

    public function test_team_owner_can_add_member_to_their_team()
    {
        $owner = User::factory()->create(['USE_PASSWORD' => Hash::make('password123')]);
        $member = User::factory()->create();

        // Login and create team
        $loginResponse = $this->postJson('/api/login', [
            'mail' => $owner->USE_MAIL,
            'password' => 'password123',
        ]);
        $token = $loginResponse['data']['access_token'];

        $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams', ['name' => 'Test Team']);

        // Owner adds member
        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/teams/addMember', [
                'user_id' => $member->USE_ID,
                'team_id' => 1,
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
                    'team_id' => 1,
                    'user_id' => $member->USE_ID,
                ]
            ]);

        $this->assertDatabaseHas('SAN_USERS_TEAMS', [
            'USE_ID' => $member->USE_ID,
            'TEA_ID' => 1,
        ]);
    }
}

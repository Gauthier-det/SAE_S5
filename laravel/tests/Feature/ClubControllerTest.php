<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Club;
use App\Models\User;
use App\Models\Address;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\InitialDatabaseSeeder;

class ClubControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $address;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialDatabaseSeeder::class);

        // Use the admin user from seeder
        $this->user = User::where('USE_MAIL', 'admin.site@example.com')->first();

        // Create an additional address for tests
        $this->address = Address::create([
            'ADD_POSTAL_CODE' => 75001,
            'ADD_CITY' => 'Paris',
            'ADD_STREET_NAME' => 'Rue de Test',
            'ADD_STREET_NUMBER' => '42',
        ]);
    }

    /**
     * Test that getAllClubs returns all clubs
     */
    public function test_get_all_clubs()
    {
        $response = $this->getJson('/api/clubs');
        
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test that getClubById returns a 404 error if club does not exist
     */
    public function test_get_club_by_id_not_found()
    {
        $response = $this->getJson('/api/clubs/999');
        
        $response->assertStatus(404)
                 ->assertJson(['message' => 'Club not found']);
    }

    /**
     * Test that getClubById returns an existing club
     */
    public function test_get_club_by_id_success()
    {
        $club = Club::create([
            'USE_ID' => $this->user->USE_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'Test Club',
        ]);

        $response = $this->getJson("/api/clubs/{$club->CLU_ID}");
        
        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['CLU_ID', 'USE_ID', 'ADD_ID', 'CLU_NAME']])
                 ->assertJson(['data' => ['CLU_ID' => $club->CLU_ID, 'CLU_NAME' => 'Test Club']]);
    }

    /**
     * Test that createClub creates a club with existing address
     */
    public function test_create_club()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/clubs', [
            'USE_ID' => $this->user->USE_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'New Club',
        ]);
        
        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['CLU_ID', 'USE_ID', 'ADD_ID', 'CLU_NAME']])
                 ->assertJson(['data' => ['CLU_NAME' => 'New Club']]);

        $this->assertDatabaseHas('SAN_CLUBS', [
            'USE_ID' => $this->user->USE_ID,
            'CLU_NAME' => 'New Club',
        ]);
    }

    /**
     * Test that createClubWithAddress creates both address and club
     */
    public function test_create_club_with_address()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/clubs/with-address', [
            'USE_ID' => $this->user->USE_ID,
            'CLU_NAME' => 'Club with New Address',
            'ADD_POSTAL_CODE' => 69000,
            'ADD_CITY' => 'Lyon',
            'ADD_STREET_NAME' => 'Rue de Lyon',
            'ADD_STREET_NUMBER' => '100',
        ]);
        
        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['CLU_ID', 'USE_ID', 'ADD_ID', 'CLU_NAME']]);

        $this->assertDatabaseHas('SAN_CLUBS', [
            'USE_ID' => $this->user->USE_ID,
            'CLU_NAME' => 'Club with New Address',
        ]);

        $this->assertDatabaseHas('SAN_ADDRESSES', [
            'ADD_POSTAL_CODE' => 69000,
            'ADD_CITY' => 'Lyon',
            'ADD_STREET_NAME' => 'Rue de Lyon',
            'ADD_STREET_NUMBER' => '100',
        ]);
    }

    /**
     * Test that updateClub updates a club
     */
    public function test_update_club()
    {
        Sanctum::actingAs($this->user);

        $club = Club::create([
            'USE_ID' => $this->user->USE_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'Old Club Name',
        ]);

        $response = $this->putJson("/api/clubs/{$club->CLU_ID}", [
            'CLU_NAME' => 'Updated Club Name',
        ]);
        
        $response->assertStatus(200)
                 ->assertJson(['data' => ['CLU_NAME' => 'Updated Club Name']]);

        $this->assertDatabaseHas('SAN_CLUBS', [
            'CLU_ID' => $club->CLU_ID,
            'CLU_NAME' => 'Updated Club Name',
        ]);
    }

    /**
     * Test that deleteClub deletes a club
     */
    public function test_delete_club()
    {
        Sanctum::actingAs($this->user);

        $club = Club::create([
            'USE_ID' => $this->user->USE_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'Club to Delete',
        ]);

        $response = $this->deleteJson("/api/clubs/{$club->CLU_ID}");
        
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Club deleted successfully']);

        $this->assertDatabaseMissing('SAN_CLUBS', ['CLU_ID' => $club->CLU_ID]);
    }

    /**
     * Test that createClub fails with invalid user
     */
    public function test_create_club_with_invalid_user()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/clubs', [
            'USE_ID' => 999,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'Invalid Club',
        ]);
        
        $response->assertStatus(422)
                 ->assertJsonStructure(['errors']);
    }

    /**
     * Test that updateClub returns 404 if club does not exist
     */
    public function test_update_club_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/clubs/999', [
            'CLU_NAME' => 'Non-existent Club',
        ]);
        
        $response->assertStatus(404)
                 ->assertJson(['message' => 'Club not found']);
    }

    /**
     * Test that deleteClub returns 404 if club does not exist
     */
    public function test_delete_club_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson('/api/clubs/999');
        
        $response->assertStatus(404)
                 ->assertJson(['message' => 'Club not found']);
    }
}

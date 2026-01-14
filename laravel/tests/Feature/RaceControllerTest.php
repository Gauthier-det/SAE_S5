<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Race;
use App\Models\User;
use App\Models\Raid;
use App\Models\Address;
use Laravel\Sanctum\Sanctum;

class RaceControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $raid;

    public function setUp(): void
    {
        parent::setUp();

        // Créer une adresse
        $address = Address::create([
            'ADD_POSTAL_CODE' => 75001,
            'ADD_CITY' => 'Paris',
            'ADD_STREET_NAME' => 'Rue de Test',
            'ADD_STREET_NUMBER' => '42',
        ]);

        // Créer un utilisateur
        $this->user = User::create([
            'ADD_ID' => $address->ADD_ID,
            'USE_MAIL' => 'test@example.com',
            'USE_PASSWORD' => bcrypt('password'),
            'USE_NAME' => 'Test',
            'USE_LAST_NAME' => 'User',
        ]);

        // Créer un club
        $club = $this->user->clubsCreated()->create([
            'ADD_ID' => $address->ADD_ID,
            'CLU_NAME' => 'Club Test',
        ]);

        // Créer un raid
        $this->raid = Raid::create([
            'CLU_ID' => $club->CLU_ID,
            'ADD_ID' => $address->ADD_ID,
            'USE_ID' => $this->user->USE_ID,
            'RAI_NAME' => 'Raid Test',
            'RAI_TIME_START' => '2026-01-20 10:00:00',
            'RAI_TIME_END' => '2026-01-20 18:00:00',
            'RAI_REGISTRATION_START' => '2026-01-01 00:00:00',
            'RAI_REGISTRATION_END' => '2026-01-15 23:59:59',
        ]);
    }

    /**
     * Test que getAllRaces retourne les courses
     */
    public function test_get_all_races()
    {
        $response = $this->getJson('/api/races');
        
        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test que getRaceById retourne une erreur 404 si la course n'existe pas
     */
    public function test_get_race_by_id_not_found()
    {
        $response = $this->getJson('/api/races/999');
        
        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    /**
     * Test que createRace crée une course avec les bonnes données
     */
    public function test_create_race()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/races', [
            'USE_ID' => $this->user->USE_ID,
            'RAI_ID' => $this->raid->RAI_ID,
            'RAC_TIME_START' => '2026-01-20 10:00:00',
            'RAC_TIME_END' => '2026-01-20 12:00:00',
            'RAC_TYPE' => 'Trail',
            'RAC_DIFFICULTY' => 'Hard',
            'RAC_MIN_PARTICIPANTS' => 1,
            'RAC_MAX_PARTICIPANTS' => 100,
            'RAC_MIN_TEAMS' => 1,
            'RAC_MAX_TEAMS' => 20,
            'RAC_TEAM_MEMBERS' => 5,
            'RAC_AGE_MIN' => 18,
            'RAC_AGE_MIDDLE' => 30,
            'RAC_AGE_MAX' => 65,
        ]);
        
        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['RAC_ID', 'USE_ID', 'RAI_ID']]);
    }

    /**
     * Test que getRaceById retourne une course existante
     */
    public function test_get_race_by_id_success()
    {
        $race = Race::factory()->create([
            'USE_ID' => $this->user->USE_ID,
            'RAI_ID' => $this->raid->RAI_ID,
        ]);

        $response = $this->getJson("/api/races/{$race->RAC_ID}");
        
        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['RAC_ID', 'USE_ID', 'RAI_ID']])
                 ->assertJson(['data' => ['RAC_ID' => $race->RAC_ID]]);
    }

    /**
     * Test que deleteRace supprime une course
     */
    public function test_delete_race()
    {
        Sanctum::actingAs($this->user);

        $race = Race::factory()->create([
            'USE_ID' => $this->user->USE_ID,
            'RAI_ID' => $this->raid->RAI_ID,
        ]);

        $response = $this->deleteJson("/api/races/{$race->RAC_ID}");
        
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Race deleted successfully']);

        $this->assertDatabaseMissing('SAN_RACES', ['RAC_ID' => $race->RAC_ID]);
    }
}

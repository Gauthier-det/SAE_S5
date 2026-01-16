<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Race;
use App\Models\Raid;
use App\Models\User;
use App\Models\Club;
use App\Models\Address;
use App\Models\Team;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\InitialDatabaseSeeder;
use Illuminate\Support\Facades\Hash;

class RaceControllerTest extends TestCase
{
    use RefreshDatabase;

    private $adminUser;
    private $raceManager;
    private $otherUser;
    private $club;
    private $address;
    private $raid;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialDatabaseSeeder::class);

        // Utiliser l'utilisateur admin du seeder
        $this->adminUser = User::where('USE_MAIL', 'admin.site@orient.action.fr')->first();

        // Créer une adresse pour les tests
        $this->address = Address::create([
            'ADD_POSTAL_CODE' => 75001,
            'ADD_CITY' => 'Paris',
            'ADD_STREET_NAME' => 'Rue de Test',
            'ADD_STREET_NUMBER' => '42',
        ]);

        // Créer un club pour les tests
        $this->club = Club::create([
            'USE_ID' => $this->adminUser->USE_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'Club Test',
        ]);

        // Créer un race manager avec licence et membre du club
        $this->raceManager = User::create([
            'USE_MAIL' => 'race.manager@test.fr',
            'USE_PASSWORD' => Hash::make('password'),
            'USE_NAME' => 'Manager',
            'USE_LAST_NAME' => 'Race',
            'USE_GENDER' => 'Homme',
            'USE_BIRTHDATE' => '1990-01-01',
            'USE_PHONE_NUMBER' => '0612345678',
            'USE_LICENCE_NUMBER' => 12345,
            'USE_MEMBERSHIP_DATE' => now(),
            'USE_VALIDITY' => now()->addYear(),
            'CLU_ID' => $this->club->CLU_ID,
            'ADD_ID' => $this->address->ADD_ID,
        ]);

        // Créer un autre utilisateur sans licence
        $this->otherUser = User::create([
            'USE_MAIL' => 'other.user@test.fr',
            'USE_PASSWORD' => Hash::make('password'),
            'USE_NAME' => 'Other',
            'USE_LAST_NAME' => 'User',
            'USE_GENDER' => 'Femme',
            'USE_BIRTHDATE' => '1995-01-01',
            'USE_PHONE_NUMBER' => '0698765432',
            'USE_VALIDITY' => now()->addYear(),
            'ADD_ID' => $this->address->ADD_ID,
        ]);

        // Créer un raid pour les tests
        $this->raid = Raid::create([
            'CLU_ID' => $this->club->CLU_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'USE_ID' => $this->adminUser->USE_ID,
            'RAI_NAME' => 'Raid Test',
            'RAI_TIME_START' => now()->addDays(30),
            'RAI_TIME_END' => now()->addDays(31),
            'RAI_REGISTRATION_START' => now()->addDays(1),
            'RAI_REGISTRATION_END' => now()->addDays(29),
            'RAI_NB_RACES' => 5,
        ]);
    }

    /**
     * Helper method to create a valid race
     */
    private function createValidRace($overrides = [])
    {
        return Race::create(array_merge([
            'USE_ID' => $this->raceManager->USE_ID,
            'RAI_ID' => $this->raid->RAI_ID,
            'RAC_NAME' => 'Course Test',
            'RAC_TIME_START' => now()->addDays(30),
            'RAC_TIME_END' => now()->addDays(31),
            'RAC_GENDER' => 'Mixte',
            'RAC_TYPE' => 'Trail',
            'RAC_DIFFICULTY' => 'Difficile',
            'RAC_MIN_PARTICIPANTS' => 10,
            'RAC_MAX_PARTICIPANTS' => 100,
            'RAC_MIN_TEAMS' => 5,
            'RAC_MAX_TEAMS' => 50,
            'RAC_MIN_TEAM_MEMBERS' => 2,
            'RAC_MAX_TEAM_MEMBERS' => 4,
            'RAC_AGE_MIN' => 18,
            'RAC_AGE_MIDDLE' => 40,
            'RAC_AGE_MAX' => 70,
            'RAC_CHIP_MANDATORY' => 0,
        ], $overrides));
    }

    /**
     * Helper method to get valid race data
     */
    private function getValidRaceData($overrides = [])
    {
        return array_merge([
            'USE_ID' => $this->raceManager->USE_ID,
            'RAI_ID' => $this->raid->RAI_ID,
            'RAC_NAME' => 'Nouvelle Course',
            'RAC_TIME_START' => now()->addDays(30)->toDateTimeString(),
            'RAC_TIME_END' => now()->addDays(31)->toDateTimeString(),
            'RAC_GENDER' => 'Mixte',
            'RAC_TYPE' => 'Trail',
            'RAC_DIFFICULTY' => 'Difficile',
            'RAC_MIN_PARTICIPANTS' => 10,
            'RAC_MAX_PARTICIPANTS' => 100,
            'RAC_MIN_TEAMS' => 5,
            'RAC_MAX_TEAMS' => 50,
            'RAC_MIN_TEAM_MEMBERS' => 2,
            'RAC_MAX_TEAM_MEMBERS' => 4,
            'RAC_AGE_MIN' => 18,
            'RAC_AGE_MIDDLE' => 40,
            'RAC_AGE_MAX' => 70,
            'RAC_CHIP_MANDATORY' => 0,
        ], $overrides);
    }

    public function test_get_all_races()
    {
        $response = $this->getJson('/api/races');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_get_race_by_id_not_found()
    {
        $response = $this->getJson('/api/races/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    public function test_get_race_by_id_success()
    {
        $race = $this->createValidRace();

        $response = $this->getJson("/api/races/{$race->RAC_ID}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['RAC_ID', 'USE_ID', 'RAI_ID', 'RAC_NAME', 'RAC_TYPE']])
                 ->assertJson(['data' => ['RAC_ID' => $race->RAC_ID, 'RAC_NAME' => 'Course Test']]);
    }

    public function test_get_races_by_raid()
    {
        $this->createValidRace();

        $response = $this->getJson("/api/raids/{$this->raid->RAI_ID}/races");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data'])
                 ->assertJsonCount(1, 'data');
    }

    public function test_get_race_results_not_found()
    {
        $response = $this->getJson('/api/races/999/results');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    public function test_get_race_results_success()
    {
        $race = $this->createValidRace();

        $response = $this->getJson("/api/races/{$race->RAC_ID}/results");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_get_race_prices_not_found()
    {
        $response = $this->getJson('/api/races/999/prices');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    public function test_get_race_prices_success()
    {
        $race = $this->createValidRace();

        $response = $this->getJson("/api/races/{$race->RAC_ID}/prices");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    public function test_get_race_details_not_found()
    {
        $response = $this->getJson('/api/races/999/details');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    public function test_get_race_details_success()
    {
        $race = $this->createValidRace();

        $response = $this->getJson("/api/races/{$race->RAC_ID}/details");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'RAC_ID',
                         'stats',
                         'formatted_categories',
                         'teams_list'
                     ]
                 ]);
    }

    public function test_create_race_requires_authentication()
    {
        $response = $this->postJson('/api/races', $this->getValidRaceData());

        $response->assertStatus(401);
    }

    public function test_create_race_success()
    {
        Sanctum::actingAs($this->adminUser);

        $response = $this->postJson('/api/races', $this->getValidRaceData());

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['RAC_ID', 'RAC_NAME', 'RAC_TYPE']])
                 ->assertJson(['data' => ['RAC_NAME' => 'Nouvelle Course']]);

        $this->assertDatabaseHas('SAN_RACES', [
            'RAI_ID' => $this->raid->RAI_ID,
            'RAC_NAME' => 'Nouvelle Course',
        ]);
    }

    public function test_create_race_with_invalid_data()
    {
        Sanctum::actingAs($this->adminUser);

        $response = $this->postJson('/api/races', [
            'USE_ID' => $this->raceManager->USE_ID,
            'RAI_ID' => 999, // Invalide
            'RAC_NAME' => 'Course Invalide',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure(['errors']);
    }

    public function test_create_race_unauthorized_user()
    {
        Sanctum::actingAs($this->otherUser);

        $response = $this->postJson('/api/races', $this->getValidRaceData());

        $response->assertStatus(403)
                 ->assertJson(['message' => 'Unauthorized. Only the raid manager can create races for this raid.']);
    }

    public function test_create_race_with_prices_success()
    {
        Sanctum::actingAs($this->adminUser);

        $data = $this->getValidRaceData([
            'CAT_1_PRICE' => 50.00,
            'CAT_2_PRICE' => 35.00,
            'CAT_3_PRICE' => 25.00,
        ]);

        $response = $this->postJson('/api/races/with-prices', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['RAC_ID', 'RAC_NAME', 'categories']]);

        $this->assertDatabaseHas('SAN_RACES', [
            'RAI_ID' => $this->raid->RAI_ID,
            'RAC_NAME' => 'Nouvelle Course',
        ]);

        $raceId = $response->json('data.RAC_ID');
        $this->assertDatabaseHas('SAN_CATEGORIES_RACES', [
            'RAC_ID' => $raceId,
            'CAT_ID' => 1,
            'CAR_PRICE' => 50.00,
        ]);
    }

    public function test_update_race_success()
    {
        $race = $this->createValidRace();
        Sanctum::actingAs($this->raceManager);

        $response = $this->putJson("/api/races/{$race->RAC_ID}", [
            'RAC_NAME' => 'Course Modifiée',
            'RAC_DIFFICULTY' => 'Facile',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['RAC_NAME' => 'Course Modifiée', 'RAC_DIFFICULTY' => 'Facile']]);

        $this->assertDatabaseHas('SAN_RACES', [
            'RAC_ID' => $race->RAC_ID,
            'RAC_NAME' => 'Course Modifiée',
        ]);
    }

    public function test_update_race_not_found()
    {
        Sanctum::actingAs($this->raceManager);

        $response = $this->putJson('/api/races/999', [
            'RAC_NAME' => 'Course Inexistante',
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    public function test_update_race_unauthorized_user()
    {
        $race = $this->createValidRace();
        Sanctum::actingAs($this->otherUser);

        $response = $this->putJson("/api/races/{$race->RAC_ID}", [
            'RAC_NAME' => 'Tentative Modification',
        ]);

        $response->assertStatus(403)
                 ->assertJson(['message' => 'Unauthorized. You can only update races you created.']);
    }

    public function test_delete_race_success()
    {
        $race = $this->createValidRace();
        Sanctum::actingAs($this->raceManager);

        $response = $this->deleteJson("/api/races/{$race->RAC_ID}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Race deleted successfully']);

        $this->assertDatabaseMissing('SAN_RACES', ['RAC_ID' => $race->RAC_ID]);
    }

    public function test_delete_race_not_found()
    {
        Sanctum::actingAs($this->raceManager);

        $response = $this->deleteJson('/api/races/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }

    public function test_delete_race_unauthorized_user()
    {
        $race = $this->createValidRace();
        Sanctum::actingAs($this->otherUser);

        $response = $this->deleteJson("/api/races/{$race->RAC_ID}");

        $response->assertStatus(403)
                 ->assertJson(['message' => 'Unauthorized. You can only delete races you created.']);
    }

    public function test_store_team_race_result_success()
    {
        $race = $this->createValidRace();
        $team = Team::create([
            'USE_ID' => $this->raceManager->USE_ID,
            'TEA_NAME' => 'Team Test',
        ]);

        Sanctum::actingAs($this->raceManager);

        $response = $this->postJson("/api/races/{$race->RAC_ID}/team-results", [
            'TEA_ID' => $team->TEA_ID,
            'TER_TIME' => '02:30:45',
            'TER_IS_VALID' => 1,
            'TER_RACE_NUMBER' => 42,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Team race result created successfully']);

        $this->assertDatabaseHas('SAN_TEAMS_RACES', [
            'RAC_ID' => $race->RAC_ID,
            'TEA_ID' => $team->TEA_ID,
            'TER_RACE_NUMBER' => 42,
        ]);
    }

    public function test_store_team_race_result_race_not_found()
    {
        Sanctum::actingAs($this->raceManager);

        $response = $this->postJson('/api/races/999/team-results', [
            'TEA_ID' => 1,
            'TER_TIME' => '02:30:45',
            'TER_IS_VALID' => 1,
            'TER_RACE_NUMBER' => 42,
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Race not found']);
    }
}

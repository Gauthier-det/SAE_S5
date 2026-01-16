<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Raid;
use App\Models\User;
use App\Models\Club;
use App\Models\Address;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\InitialDatabaseSeeder;

class RaidControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $club;
    private $address;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(InitialDatabaseSeeder::class);

        // Utiliser l'utilisateur admin du seeder
        $this->user = User::where('USE_MAIL', 'admin.site@orient.action.fr')->first();

        // Créer une adresse supplémentaire pour les tests
        $this->address = Address::create([
            'ADD_POSTAL_CODE' => 75001,
            'ADD_CITY' => 'Paris',
            'ADD_STREET_NAME' => 'Rue de Test',
            'ADD_STREET_NUMBER' => '42',
        ]);

        // Créer un club pour les tests
        $this->club = Club::create([
            'USE_ID' => $this->user->USE_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'CLU_NAME' => 'Club Test',
        ]);
    }

    /**
     * Test que getAllRaids retourne tous les raids
     */
    public function test_get_all_raids()
    {
        $response = $this->getJson('/api/raids');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test que getRaidById retourne une erreur 404 si le raid n'existe pas
     */
    public function test_get_raid_by_id_not_found()
    {
        $response = $this->getJson('/api/raids/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Raid not found']);
    }

    /**
     * Test que getRaidById retourne un raid existant
     */
    public function test_get_raid_by_id_success()
    {
        $raid = Raid::create([
            'CLU_ID' => $this->club->CLU_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'USE_ID' => $this->user->USE_ID,
            'RAI_NAME' => 'Raid Test',
            'RAI_TIME_START' => now()->addDays(30),
            'RAI_TIME_END' => now()->addDays(31),
            'RAI_REGISTRATION_START' => now()->addDays(1),
            'RAI_REGISTRATION_END' => now()->addDays(29),
            'RAI_NB_RACES' => 5,
        ]);

        $response = $this->getJson("/api/raids/{$raid->RAI_ID}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => ['RAI_ID', 'CLU_ID', 'ADD_ID', 'USE_ID', 'RAI_NAME']])
                 ->assertJson(['data' => ['RAI_ID' => $raid->RAI_ID, 'RAI_NAME' => 'Raid Test']]);
    }

    /**
     * Test que createRaid crée un raid avec les bonnes données
     */
    public function test_create_raid()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/raids', [
            'CLU_ID' => $this->club->CLU_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'USE_ID' => $this->user->USE_ID,
            'RAI_NAME' => 'Nouveau Raid',
            'RAI_MAIL' => 'contact@raid.com',
            'RAI_PHONE_NUMBER' => '0123456789',
            'RAI_WEB_SITE' => 'https://raid.com',
            'RAI_IMAGE' => 'https://image.com/raid.jpg',
            'RAI_TIME_START' => now()->addDays(30)->toDateTimeString(),
            'RAI_TIME_END' => now()->addDays(31)->toDateTimeString(),
            'RAI_REGISTRATION_START' => now()->addDays(1)->toDateTimeString(),
            'RAI_REGISTRATION_END' => now()->addDays(29)->toDateTimeString(),
            'RAI_NB_RACES' => 5,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['RAI_ID', 'CLU_ID', 'ADD_ID', 'USE_ID', 'RAI_NAME']])
                 ->assertJson(['data' => ['RAI_NAME' => 'Nouveau Raid']]);

        $this->assertDatabaseHas('SAN_RAIDS', [
            'CLU_ID' => $this->club->CLU_ID,
            'RAI_NAME' => 'Nouveau Raid',
        ]);
    }

    /**
     * Test que updateRaid met à jour un raid
     */
    public function test_update_raid()
    {
        Sanctum::actingAs($this->user);

        $raid = Raid::create([
            'CLU_ID' => $this->club->CLU_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'USE_ID' => $this->user->USE_ID,
            'RAI_NAME' => 'Ancien Nom',
            'RAI_TIME_START' => now()->addDays(30),
            'RAI_TIME_END' => now()->addDays(31),
            'RAI_REGISTRATION_START' => now()->addDays(1),
            'RAI_REGISTRATION_END' => now()->addDays(29),
            'RAI_NB_RACES' => 5,
        ]);

        $response = $this->putJson("/api/raids/{$raid->RAI_ID}", [
            'RAI_NAME' => 'Nouveau Nom',
            'CLU_ID' => $raid->CLU_ID,
            'ADD_ID' => $raid->ADD_ID,
            'USE_ID' => $raid->USE_ID,
            'RAI_MAIL' => 'test@orient.action.fr',
            'RAI_PHONE_NUMBER' => $raid->RAI_PHONE_NUMBER,
            'RAI_WEB_SITE' => $raid->RAI_WEB_SITE,
            'RAI_IMAGE' => $raid->RAI_IMAGE,
            'RAI_TIME_START' => $raid->RAI_TIME_START,
            'RAI_TIME_END' => $raid->RAI_TIME_END,
            'RAI_REGISTRATION_START' => $raid->RAI_REGISTRATION_START,
            'RAI_REGISTRATION_END' => $raid->RAI_REGISTRATION_END,
            'RAI_NB_RACES' => $raid->RAI_NB_RACES,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['RAI_NAME' => 'Nouveau Nom']]);

        $this->assertDatabaseHas('SAN_RAIDS', [
            'RAI_ID' => $raid->RAI_ID,
            'RAI_NAME' => 'Nouveau Nom',
        ]);
    }

    /**
     * Test que deleteRaid supprime un raid
     */
    public function test_delete_raid()
    {
        Sanctum::actingAs($this->user);

        $raid = Raid::create([
            'CLU_ID' => $this->club->CLU_ID,
            'ADD_ID' => $this->address->ADD_ID,
            'USE_ID' => $this->user->USE_ID,
            'RAI_NAME' => 'Raid à Supprimer',
            'RAI_TIME_START' => now()->addDays(30),
            'RAI_TIME_END' => now()->addDays(31),
            'RAI_REGISTRATION_START' => now()->addDays(1),
            'RAI_REGISTRATION_END' => now()->addDays(29),
            'RAI_NB_RACES' => 5,
        ]);

        $response = $this->deleteJson("/api/raids/{$raid->RAI_ID}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Raid deleted successfully']);

        $this->assertDatabaseMissing('SAN_RAIDS', ['RAI_ID' => $raid->RAI_ID]);
    }

    /**
     * Test que createRaid échoue avec des données invalides
     */
    public function test_create_raid_with_invalid_data()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/raids', [
            'CLU_ID' => 999, // Invalide
            'ADD_ID' => $this->address->ADD_ID,
            'USE_ID' => $this->user->USE_ID,
            'RAI_NAME' => 'Raid Invalide',
            'RAI_TIME_START' => now()->addDays(30)->toDateTimeString(),
            'RAI_TIME_END' => now()->addDays(31)->toDateTimeString(),
            'RAI_REGISTRATION_START' => now()->addDays(1)->toDateTimeString(),
            'RAI_REGISTRATION_END' => now()->addDays(29)->toDateTimeString(),
            'RAI_NB_RACES' => 5,
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure(['errors']);
    }

    /**
     * Test que updateRaid retourne 404 si le raid n'existe pas
     */
    public function test_update_raid_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/raids/999', [
            'RAI_NAME' => 'Raid Inexistant',
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Raid not found']);
    }

    /**
     * Test que deleteRaid retourne 404 si le raid n'existe pas
     */
    public function test_delete_raid_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson('/api/raids/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Raid not found']);
    }
}
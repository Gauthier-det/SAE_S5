<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Address;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\InitialDatabaseSeeder;

class AddressControllerTest extends TestCase
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
     * Test get all addresses (admin only)
     */
    public function test_get_all_addresses()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/addresses');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test get address by id
     */
    public function test_get_address_by_id()
    {
        Sanctum::actingAs($this->user);

        $address = Address::first();

        $response = $this->getJson("/api/addresses/{$address->ADD_ID}");

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test create address
     */
    public function test_create_address()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/addresses', [
            'ADD_POSTAL_CODE' => 75002,
            'ADD_CITY' => 'Paris',
            'ADD_STREET_NAME' => 'Rue de la Paix',
            'ADD_STREET_NUMBER' => '10',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('SAN_ADDRESSES', [
            'ADD_POSTAL_CODE' => 75002,
            'ADD_CITY' => 'Paris',
        ]);
    }

    /**
     * Test update address
     */
    public function test_update_address()
    {
        Sanctum::actingAs($this->user);

        $address = Address::create([
            'ADD_POSTAL_CODE' => 75003,
            'ADD_CITY' => 'Paris',
            'ADD_STREET_NAME' => 'Rue Test',
            'ADD_STREET_NUMBER' => '5',
        ]);

        $response = $this->putJson("/api/addresses/{$address->ADD_ID}", [
            'ADD_CITY' => 'Lyon',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['ADD_CITY' => 'Lyon']]);

        $this->assertDatabaseHas('SAN_ADDRESSES', [
            'ADD_ID' => $address->ADD_ID,
            'ADD_CITY' => 'Lyon',
        ]);
    }

    /**
     * Test delete address (admin only)
     */
    public function test_delete_address()
    {
        Sanctum::actingAs($this->admin);

        $address = Address::create([
            'ADD_POSTAL_CODE' => 75004,
            'ADD_CITY' => 'Paris',
        ]);

        $response = $this->deleteJson("/api/addresses/{$address->ADD_ID}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Address deleted successfully']);

        $this->assertDatabaseMissing('SAN_ADDRESSES', ['ADD_ID' => $address->ADD_ID]);
    }

    /**
     * Test get address by id not found
     */
    public function test_get_address_by_id_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/addresses/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Address not found']);
    }

    /**
     * Test update address not found
     */
    public function test_update_address_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->putJson('/api/addresses/999', [
            'ADD_CITY' => 'Updated',
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Address not found']);
    }

    /**
     * Test delete address not found
     */
    public function test_delete_address_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->deleteJson('/api/addresses/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Address not found']);
    }
}
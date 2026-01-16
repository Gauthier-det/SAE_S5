<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\InitialDatabaseSeeder;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(InitialDatabaseSeeder::class);
        $this->admin = User::where('USE_MAIL', 'admin.site@orient.action.fr')->first();
    }

    /**
     * Test get all roles
     */
    public function test_get_all_roles()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/roles');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test get role by id
     */
    public function test_get_role_by_id()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/roles/1');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data']);
    }

    /**
     * Test create role
     */
    public function test_create_role()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->postJson('/api/roles', [
            'ROL_NAME' => 'New Role',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('SAN_ROLES', [
            'ROL_NAME' => 'New Role',
        ]);
    }

    /**
     * Test update role
     */
    public function test_update_role()
    {
        Sanctum::actingAs($this->admin);

        $role = Role::create(['ROL_NAME' => 'Old Role']);

        $response = $this->putJson("/api/roles/{$role->ROL_ID}", [
            'ROL_NAME' => 'Updated Role',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['ROL_NAME' => 'Updated Role']]);

        $this->assertDatabaseHas('SAN_ROLES', [
            'ROL_ID' => $role->ROL_ID,
            'ROL_NAME' => 'Updated Role',
        ]);
    }

    /**
     * Test delete role
     */
    public function test_delete_role()
    {
        Sanctum::actingAs($this->admin);

        $role = Role::create(['ROL_NAME' => 'Role to Delete']);

        $response = $this->deleteJson("/api/roles/{$role->ROL_ID}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Role deleted successfully']);

        $this->assertDatabaseMissing('SAN_ROLES', ['ROL_ID' => $role->ROL_ID]);
    }

    /**
     * Test get role by id not found
     */
    public function test_get_role_by_id_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/roles/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Role not found']);
    }

    /**
     * Test update role not found
     */
    public function test_update_role_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->putJson('/api/roles/999', [
            'ROL_NAME' => 'Updated',
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Role not found']);
    }

    /**
     * Test delete role not found
     */
    public function test_delete_role_not_found()
    {
        Sanctum::actingAs($this->admin);

        $response = $this->deleteJson('/api/roles/999');

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Role not found']);
    }
}
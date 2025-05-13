<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionBasedUITest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'view permissions']);

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'view permissions'
        ]);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo(['view users', 'view roles']);
    }

    /**
     * Test that admin can see all user management options.
     *
     * @return void
     */
    public function test_admin_can_see_all_user_management_options()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Add New User');
        $response->assertSee('Edit User');
        $response->assertSee('Delete');
    }

    /**
     * Test that manager can only see view options.
     *
     * @return void
     */
    public function test_manager_can_only_see_view_options()
    {
        $manager = User::factory()->create();
        $manager->assignRole('manager');

        $response = $this->actingAs($manager)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Add New User');
        $response->assertDontSee('Edit User');
        $response->assertDontSee('Delete');
    }

    /**
     * Test that unauthorized access is redirected to 403 page.
     *
     * @return void
     */
    public function test_unauthorized_access_shows_403_page()
    {
        $user = User::factory()->create();
        // No permissions assigned

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
        $response->assertSee('Access Forbidden');
    }

    /**
     * Test that user roles are displayed correctly.
     *
     * @return void
     */
    public function test_user_roles_are_displayed_correctly()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('admin.users.show', $admin->id));

        $response->assertStatus(200);
        $response->assertSee('Admin');
    }
}

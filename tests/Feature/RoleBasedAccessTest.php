<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user with admin role can access admin dashboard.
     *
     * @return void
     */
    public function test_admin_can_access_admin_dashboard()
    {
        // Create permissions
        Permission::create(['name' => 'view products']);

        // Create admin role and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('view products');

        // Create admin user and assign role
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Login as admin
        $this->actingAs($admin);

        // Access admin dashboard
        $response = $this->get('/admin/index');

        // Assert successful response
        $response->assertStatus(200);
    }

    /**
     * Test that a user without admin role cannot access admin dashboard.
     *
     * @return void
     */
    public function test_non_admin_cannot_access_admin_dashboard()
    {
        // Create user role
        $userRole = Role::create(['name' => 'user']);

        // Create regular user and assign role
        $user = User::factory()->create();
        $user->assignRole('user');

        // Login as regular user
        $this->actingAs($user);

        // Try to access admin dashboard
        $response = $this->get('/admin/index');

        // Assert forbidden response
        $response->assertStatus(403);
    }

    /**
     * Test that a user with specific permission can access a protected route.
     *
     * @return void
     */
    public function test_user_with_permission_can_access_protected_route()
    {
        // Create permissions
        Permission::create(['name' => 'view products']);

        // Create admin role and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('view products');

        // Create user and assign role
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Login as user
        $this->actingAs($user);

        // Access route that requires 'view products' permission
        $response = $this->get('/admin/product');

        // Assert successful response
        $response->assertStatus(200);
    }

    /**
     * Test that a user without specific permission cannot access a protected route.
     *
     * @return void
     */
    public function test_user_without_permission_cannot_access_protected_route()
    {
        // Create permissions
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);

        // Create user role with only view permission
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('view products');

        // Create user and assign role
        $user = User::factory()->create();
        $user->assignRole('user');

        // Login as user
        $this->actingAs($user);

        // Try to access route that requires 'create products' permission
        $response = $this->get('/admin/product/create');

        // Assert forbidden response
        $response->assertStatus(403);
    }
}

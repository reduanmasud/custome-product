<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionStructureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database with roles and permissions
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    public function test_role_hierarchy_exists()
    {
        // Check that all expected roles exist
        $this->assertDatabaseHas('roles', ['name' => 'super-admin']);
        $this->assertDatabaseHas('roles', ['name' => 'admin']);
        $this->assertDatabaseHas('roles', ['name' => 'manager']);
        $this->assertDatabaseHas('roles', ['name' => 'user']);
    }

    public function test_permission_groups_exist()
    {
        // Check that permissions from each group exist
        $this->assertDatabaseHas('permissions', ['name' => 'view users']);
        $this->assertDatabaseHas('permissions', ['name' => 'view roles']);
        $this->assertDatabaseHas('permissions', ['name' => 'view permissions']);
        $this->assertDatabaseHas('permissions', ['name' => 'view products']);
        $this->assertDatabaseHas('permissions', ['name' => 'view categories']);
        $this->assertDatabaseHas('permissions', ['name' => 'view orders']);
        $this->assertDatabaseHas('permissions', ['name' => 'view settings']);
    }

    public function test_super_admin_has_all_permissions()
    {
        $superAdminRole = Role::findByName('super-admin');
        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) {
            $this->assertTrue($superAdminRole->hasPermissionTo($permission->name));
        }
    }

    public function test_admin_has_correct_permissions()
    {
        $adminRole = Role::findByName('admin');

        // Admin should have these permissions
        $this->assertTrue($adminRole->hasPermissionTo('view users'));
        $this->assertTrue($adminRole->hasPermissionTo('create users'));
        $this->assertTrue($adminRole->hasPermissionTo('edit users'));

        // Admin should NOT have these permissions
        $this->assertFalse($adminRole->hasPermissionTo('delete users'));
        $this->assertFalse($adminRole->hasPermissionTo('create roles'));
        $this->assertFalse($adminRole->hasPermissionTo('manage backups'));
    }

    public function test_manager_has_correct_permissions()
    {
        $managerRole = Role::findByName('manager');

        // Manager should have these permissions
        $this->assertTrue($managerRole->hasPermissionTo('view users'));
        $this->assertTrue($managerRole->hasPermissionTo('create products'));
        $this->assertTrue($managerRole->hasPermissionTo('process orders'));

        // Manager should NOT have these permissions
        $this->assertFalse($managerRole->hasPermissionTo('create users'));
        $this->assertFalse($managerRole->hasPermissionTo('view roles'));
        $this->assertFalse($managerRole->hasPermissionTo('delete products'));
    }

    public function test_user_has_correct_permissions()
    {
        $userRole = Role::findByName('user');

        // User should have these permissions
        $this->assertTrue($userRole->hasPermissionTo('view products'));
        $this->assertTrue($userRole->hasPermissionTo('view categories'));
        $this->assertTrue($userRole->hasPermissionTo('create orders'));

        // User should NOT have these permissions
        $this->assertFalse($userRole->hasPermissionTo('view users'));
        $this->assertFalse($userRole->hasPermissionTo('create products'));
        $this->assertFalse($userRole->hasPermissionTo('edit orders'));
    }

    public function test_permission_helper_methods()
    {
        // Create a user with admin role
        $user = User::factory()->create();
        $user->assignRole('admin');

        // Test helper methods
        $this->assertTrue($user->isAdmin());
        $this->assertFalse($user->isSuperAdmin());
        $this->assertTrue($user->isAdminLevel());
        $this->assertTrue($user->canManage('product'));
        $this->assertTrue($user->hasFullAccessTo('product'));
        $this->assertFalse($user->hasFullAccessTo('user')); // Admin can't delete users

        // Test hasAnyPermission (from Spatie's HasRoles trait)
        $this->assertTrue($user->hasAnyPermission(['view users', 'delete users']));
        $this->assertFalse($user->hasAnyPermission(['create roles', 'delete roles']));

        // Test hasAllPermissions (from Spatie's HasRoles trait)
        $this->assertTrue($user->hasAllPermissions(['view products', 'create products']));
        $this->assertFalse($user->hasAllPermissions(['view users', 'delete users']));
    }
}

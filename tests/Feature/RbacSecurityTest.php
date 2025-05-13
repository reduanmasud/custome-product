<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Audit\Role;
use App\Models\Audit\Permission;
use App\Services\RbacService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Exception;

class RbacSecurityTest extends TestCase
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
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'view audit logs']);

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view roles', 'view permissions', 'view audit logs'
        ]);
    }

    /**
     * Test that audit logs are created when roles are modified.
     *
     * @return void
     */
    public function test_audit_logs_are_created_for_role_changes()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin);

        // Create a new role
        $rbacService = app(RbacService::class);
        $role = $rbacService->createRole('test-role', ['view users']);

        // Check that an audit log was created
        $this->assertDatabaseHas('audits', [
            'auditable_type' => get_class($role),
            'auditable_id' => $role->id,
            'event' => 'created',
        ]);

        // Update the role
        $rbacService->updateRole($role, 'updated-role', ['view users', 'edit users']);

        // Check that an audit log was created for the update
        $this->assertDatabaseHas('audits', [
            'auditable_type' => get_class($role),
            'auditable_id' => $role->id,
            'event' => 'updated',
        ]);

        // Delete the role
        $rbacService->deleteRole($role);

        // Check that an audit log was created for the deletion
        $this->assertDatabaseHas('audits', [
            'auditable_type' => get_class($role),
            'auditable_id' => $role->id,
            'event' => 'deleted',
        ]);
    }

    /**
     * Test that critical roles cannot be deleted.
     *
     * @return void
     */
    public function test_critical_roles_cannot_be_deleted()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin);

        $rbacService = app(RbacService::class);
        $superAdminRole = Role::where('name', 'super-admin')->first();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot delete critical role: super-admin');

        $rbacService->deleteRole($superAdminRole);
    }

    /**
     * Test that roles with users cannot be deleted.
     *
     * @return void
     */
    public function test_roles_with_users_cannot_be_deleted()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin);

        $rbacService = app(RbacService::class);
        $adminRole = Role::where('name', 'admin')->first();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot delete role that is assigned to users');

        $rbacService->deleteRole($adminRole);
    }

    /**
     * Test that critical permissions cannot be deleted.
     *
     * @return void
     */
    public function test_critical_permissions_cannot_be_deleted()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin);

        $rbacService = app(RbacService::class);
        $viewUsersPermission = Permission::where('name', 'view users')->first();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot delete critical permission: view users');

        $rbacService->deletePermission($viewUsersPermission);
    }

    /**
     * Test that super-admin role always has all permissions.
     *
     * @return void
     */
    public function test_super_admin_always_has_all_permissions()
    {
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $this->actingAs($admin);

        $rbacService = app(RbacService::class);
        $superAdminRole = Role::where('name', 'super-admin')->first();

        // Try to update super-admin with only some permissions
        $rbacService->updateRole($superAdminRole, 'super-admin', ['view users']);

        // Check that super-admin still has all permissions
        $this->assertEquals(
            Permission::count(),
            $superAdminRole->permissions->count(),
            'Super-admin should have all permissions'
        );
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SpatiePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_roles_and_permissions_can_be_created()
    {
        // Create a permission
        $permission = Permission::create(['name' => 'test permission']);
        $this->assertDatabaseHas('permissions', ['name' => 'test permission']);

        // Create a role
        $role = Role::create(['name' => 'test role']);
        $this->assertDatabaseHas('roles', ['name' => 'test role']);

        // Assign permission to role
        $role->givePermissionTo($permission);
        $this->assertTrue($role->hasPermissionTo('test permission'));
    }

    public function test_user_can_be_assigned_role()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a role
        $role = Role::create(['name' => 'test role']);

        // Assign role to user
        $user->assignRole($role);

        // Check if user has role
        $this->assertTrue($user->hasRole('test role'));
    }

    public function test_user_can_be_assigned_permission()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a permission
        $permission = Permission::create(['name' => 'test permission']);

        // Create a role with the permission
        $role = Role::create(['name' => 'test role']);
        $role->givePermissionTo($permission);

        // Assign role to user
        $user->assignRole($role);

        // Check if user has permission
        $this->assertTrue($user->hasPermissionTo('test permission'));
    }
}

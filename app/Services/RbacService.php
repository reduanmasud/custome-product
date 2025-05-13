<?php

namespace App\Services;

use App\Models\Audit\Role;
use App\Models\Audit\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class RbacService
{
    /**
     * List of critical permissions that cannot be removed
     *
     * @var array
     */
    protected $criticalPermissions = [
        'view users',
        'create users',
        'edit users',
        'delete users',
        'view roles',
        'create roles',
        'edit roles',
        'delete roles',
        'view permissions',
    ];

    /**
     * List of critical roles that cannot be deleted
     *
     * @var array
     */
    protected $criticalRoles = [
        'super-admin',
    ];

    /**
     * Get all roles with their permissions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Get all permissions grouped by module
     *
     * @return array
     */
    public function getAllPermissionsGrouped()
    {
        $permissions = Permission::all();
        
        return $permissions->groupBy(function($permission) {
            $parts = explode(' ', $permission->name);
            return $parts[0]; // Group by first word (module name)
        });
    }

    /**
     * Create a new role with permissions
     *
     * @param string $name
     * @param array $permissions
     * @return Role
     */
    public function createRole(string $name, array $permissions = [])
    {
        try {
            DB::beginTransaction();
            
            $role = Role::create(['name' => $name]);
            
            if (!empty($permissions)) {
                $role->syncPermissions($permissions);
            }
            
            DB::commit();
            
            Log::info('Role created', [
                'role' => $name,
                'permissions' => $permissions,
                'user_id' => auth()->id(),
            ]);
            
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create role', [
                'role' => $name,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Update a role with permissions
     *
     * @param Role $role
     * @param string $name
     * @param array $permissions
     * @return Role
     */
    public function updateRole(Role $role, string $name, array $permissions = [])
    {
        try {
            DB::beginTransaction();
            
            // Check if this is a critical role
            if (in_array($role->name, $this->criticalRoles) && $role->name !== $name) {
                throw new Exception("Cannot rename critical role: {$role->name}");
            }
            
            $role->name = $name;
            $role->save();
            
            // If this is a super-admin role, ensure it has all permissions
            if ($role->name === 'super-admin') {
                $role->syncPermissions(Permission::all());
            } else {
                $role->syncPermissions($permissions);
            }
            
            DB::commit();
            
            Log::info('Role updated', [
                'role_id' => $role->id,
                'role_name' => $name,
                'permissions' => $permissions,
                'user_id' => auth()->id(),
            ]);
            
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update role', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Delete a role
     *
     * @param Role $role
     * @return bool
     */
    public function deleteRole(Role $role)
    {
        try {
            // Check if this is a critical role
            if (in_array($role->name, $this->criticalRoles)) {
                throw new Exception("Cannot delete critical role: {$role->name}");
            }
            
            // Check if role is assigned to any users
            if ($role->users->count() > 0) {
                throw new Exception("Cannot delete role that is assigned to users");
            }
            
            $roleId = $role->id;
            $roleName = $role->name;
            
            $role->delete();
            
            Log::info('Role deleted', [
                'role_id' => $roleId,
                'role_name' => $roleName,
                'user_id' => auth()->id(),
            ]);
            
            return true;
        } catch (Exception $e) {
            Log::error('Failed to delete role', [
                'role_id' => $role->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Create a new permission
     *
     * @param string $name
     * @return Permission
     */
    public function createPermission(string $name)
    {
        try {
            $permission = Permission::create(['name' => $name]);
            
            Log::info('Permission created', [
                'permission' => $name,
                'user_id' => auth()->id(),
            ]);
            
            return $permission;
        } catch (Exception $e) {
            Log::error('Failed to create permission', [
                'permission' => $name,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Delete a permission
     *
     * @param Permission $permission
     * @return bool
     */
    public function deletePermission(Permission $permission)
    {
        try {
            // Check if this is a critical permission
            if (in_array($permission->name, $this->criticalPermissions)) {
                throw new Exception("Cannot delete critical permission: {$permission->name}");
            }
            
            // Check if permission is assigned to any roles
            if ($permission->roles->count() > 0) {
                throw new Exception("Cannot delete permission that is assigned to roles");
            }
            
            $permissionId = $permission->id;
            $permissionName = $permission->name;
            
            $permission->delete();
            
            Log::info('Permission deleted', [
                'permission_id' => $permissionId,
                'permission_name' => $permissionName,
                'user_id' => auth()->id(),
            ]);
            
            return true;
        } catch (Exception $e) {
            Log::error('Failed to delete permission', [
                'permission_id' => $permission->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Check if there is at least one super-admin user
     *
     * @return bool
     */
    public function hasSuperAdmin()
    {
        return User::role('super-admin')->count() > 0;
    }

    /**
     * Ensure at least one super-admin exists
     *
     * @param User $user
     * @return bool
     */
    public function ensureSuperAdminExists(User $user = null)
    {
        if (!$this->hasSuperAdmin() && $user) {
            $user->assignRole('super-admin');
            
            Log::info('Assigned super-admin role to user', [
                'user_id' => $user->id,
            ]);
            
            return true;
        }
        
        return false;
    }
}

<?php

namespace App\Traits;

trait HasPermissionHelpers
{
    // Removed hasAnyPermission method as it conflicts with Spatie's HasRoles trait

    // Removed hasAllPermissions method as it conflicts with Spatie's HasRoles trait

    /**
     * Check if the user has permission to manage a specific module
     *
     * @param string $module
     * @return bool
     */
    public function canManage(string $module): bool
    {
        return $this->hasAnyPermission([
            "create {$module}s",
            "edit {$module}s",
            "delete {$module}s",
        ]);
    }

    /**
     * Check if the user has full access to a specific module
     *
     * @param string $module
     * @return bool
     */
    public function hasFullAccessTo(string $module): bool
    {
        return $this->hasAllPermissions([
            "view {$module}s",
            "create {$module}s",
            "edit {$module}s",
            "delete {$module}s",
        ]);
    }

    /**
     * Check if the user is a super admin
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is a manager
     *
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    /**
     * Check if the user has any admin-level role
     *
     * @return bool
     */
    public function isAdminLevel(): bool
    {
        return $this->hasAnyRole(['super-admin', 'admin']);
    }
}

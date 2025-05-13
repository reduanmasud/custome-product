<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permission groups
        $permissionGroups = [
            // User Management
            'user' => [
                'view users',
                'create users',
                'edit users',
                'delete users',
                'impersonate users',
            ],

            // Role Management
            'role' => [
                'view roles',
                'create roles',
                'edit roles',
                'delete roles',
                'assign roles',
            ],

            // Permission Management
            'permission' => [
                'view permissions',
                'create permissions',
                'edit permissions',
                'delete permissions',
                'assign permissions',
            ],

            // Product Management
            'product' => [
                'view products',
                'create products',
                'edit products',
                'delete products',
                'publish products',
            ],

            // Category Management
            'category' => [
                'view categories',
                'create categories',
                'edit categories',
                'delete categories',
            ],

            // Order Management
            'order' => [
                'view orders',
                'create orders',
                'edit orders',
                'delete orders',
                'process orders',
            ],

            // System Settings
            'setting' => [
                'view settings',
                'edit settings',
                'manage backups',
            ],

            // Audit Logs
            'audit' => [
                'view audit logs',
            ],
        ];

        // Create all permissions
        foreach ($permissionGroups as $groupName => $permissions) {
            // Create a comment in the log to show which group we're processing
            $this->command->info("Creating permissions for {$groupName} group");

            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            }
        }

        // Create roles and assign permissions
        // Super Admin - gets all permissions
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin - gets most permissions except some critical ones
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            // User Management
            'view users',
            'create users',
            'edit users',

            // Role Management
            'view roles',
            'assign roles',

            // Permission Management
            'view permissions',

            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',
            'publish products',

            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Order Management
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'process orders',

            // System Settings
            'view settings',
            'edit settings',

            // Audit Logs
            'view audit logs',
        ]);

        // Manager - focused on product, category, and order management
        $managerRole = Role::create(['name' => 'manager', 'guard_name' => 'web']);
        $managerRole->givePermissionTo([
            // User Management
            'view users',

            // Product Management
            'view products',
            'create products',
            'edit products',
            'publish products',

            // Category Management
            'view categories',
            'create categories',
            'edit categories',

            // Order Management
            'view orders',
            'create orders',
            'edit orders',
            'process orders',
        ]);

        // Regular User - basic permissions
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'view products',
            'view categories',
            'view orders',
            'create orders',
        ]);

        // Assign roles to existing users
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('super-admin');
        }

        $regularUser = User::where('email', 'user@gmail.com')->first();
        if ($regularUser) {
            $regularUser->assignRole('user');
        }
    }
}

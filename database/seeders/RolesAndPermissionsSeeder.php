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

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Permission permissions
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view roles',
            'view permissions',
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ]);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'view products',
            'view categories',
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

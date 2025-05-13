<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Carousel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Create admin user and assign super-admin role
        $admin = User::create([
            'name' => "Admin",
            'email' => "admin@gmail.com",
            'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
        ]);

        // Create regular user and assign user role
        $user = User::create([
            'name' => "User",
            'email' => "user@gmail.com",
            'password' => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
        ]);

        for ($i=1; $i < 4; $i++) {
            Carousel::create([
                "link"=>"link $",
                "image_url"=>"demo.png"
            ]);
        }


        Category::create([
            "name" => "undefined",
            "description" => "This is an undefined Category",
        ]);

        // Seed roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Assign roles to users
        $admin->assignRole('super-admin');
        $user->assignRole('user');
    }
}

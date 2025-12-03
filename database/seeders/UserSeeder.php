<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Create the first user
        $superAdmin = User::create([
            'name' => 'Super Admin User',
            'email' => 'super.admin@moi.gov.af',
            'email_verified_at' => now(),
            'password' => bcrypt('password@123'),
            'remember_token' => Str::random(10),
            'department_id' => 1,
        ]);

        // Create the second user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@moi.gov.af',
            'email_verified_at' => now(),
            'password' => bcrypt('password@123'),
            'remember_token' => Str::random(10),
            'department_id' => 1,
        ]);

        // Create the role if it doesn't already exist
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Assign the role to both users
        $superAdmin->assignRole($role->id);
        $admin->assignRole($role->id);

        // Get all permissions and sync with the role
        $permissions = Permission::pluck('id')->toArray();
        $role->syncPermissions($permissions);
    }
}

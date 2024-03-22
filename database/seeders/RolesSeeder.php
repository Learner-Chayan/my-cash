<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = 'web'; // or 'api', depending on your application's needs

        // Create roles with the specified guard
        Role::create(['name' => 'super-admin', 'guard_name' => $guardName]);
        Role::create(['name' => 'admin', 'guard_name' => $guardName]);
        Role::create(['name' => 'agent', 'guard_name' => $guardName]);
        Role::create(['name' => 'regular', 'guard_name' => $guardName]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = 'web'; // or 'api', depending on your application's needs

        // Create roles with the specified guard
        Permission::create(['name' => 'create', 'guard_name' => $guardName]);
        Permission::create(['name' => 'edit', 'guard_name' => $guardName]);
        Permission::create(['name' => 'update', 'guard_name' => $guardName]);
        Permission::create(['name' => 'delete', 'guard_name' => $guardName]);
    }
}

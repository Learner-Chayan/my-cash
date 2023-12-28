<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionToGive = Permission::all();

        $roles = Role::all();
        foreach ($roles as $role)
        {
            $role->givePermissionTo($permissionToGive);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $key => $user)
        {
            if ($key == 0){
                $user->assignRole('super-admin');
            }elseif ($key == 1){
                $user->assignRole('admin');

            }elseif ($key == 2){
                $user->assignRole('agent');

            }elseif ($key == 3){
                $user->assignRole('customer');

            }
        }
    }
}

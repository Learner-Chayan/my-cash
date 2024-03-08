<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\Status;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'super Admin',
            'email' => 'super-admin@gmail.com',
            'phone' => '01704211825',
            'pay_id'=> 1234567891,
            'password' => bcrypt('superadmin'),
            'status' => Status::ACTIVE,
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '01704211895',
            'pay_id'=> 1234567892,
            'password' => bcrypt('1234567'),
            'status' => Status::ACTIVE,
        ]);
        User::create([
            'name' => 'agent',
            'email' => 'agent@gmail.com',
            'phone' => '01707211895',
            'pay_id'=> 1234567893,
            'password' => bcrypt('1234567'),
            'status' => Status::ACTIVE,
        ]);
        User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'phone' => '01707217895',
            'pay_id'=> 1234567894,
            'password' => bcrypt('1234567'),
            'status' => Status::ACTIVE,
        ]);
    }
}

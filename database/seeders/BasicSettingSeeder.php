<?php

namespace Database\Seeders;

use App\Models\BasicSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BasicSetting::create([
            'title' => 'Hala Pay',
            'phone' => '0152200000',
            'email' => 'halalpay@gmail.com',
            'address' => 'Dhaka,Bangladesh',
            'copy'    => 'your copy right text',
            'footer' => 'your footer text',
            'faq' => 'your faq text',
            'about' => 'your business about',
            'privacy' => 'your business privacy',
            'terms' => 'your business terms',
            'currency' => 'BDT',
        ]);
    }
}

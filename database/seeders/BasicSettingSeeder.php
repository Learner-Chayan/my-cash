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
            'title' => 'your business title',
            'phone' => 'your business phone',
            'email' => 'your business email',
            'address' => 'your business address',
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

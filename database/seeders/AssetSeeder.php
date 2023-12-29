<?php

namespace Database\Seeders;

use App\Enums\AssetStatus;
use App\Models\Asset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Asset::create([
            'title' => 'BDT',
            'status' => AssetStatus::UNLOCK,
        ]);
        Asset::create([
            'title' => 'GOLD',
            'status' => AssetStatus::UNLOCK,
        ]);
        Asset::create([
            'title' => 'SILVER',
            'status' => AssetStatus::UNLOCK,
        ]);
    }
}

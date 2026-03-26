<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EarthquakeSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            '26 km Timur Masohi',
            '10 km Barat Laut Ambon',
            'Papua Barat',
            'Manokwari Selatan',
            'Seram Bagian Timur',
            'Banda Sea',
            'Halmahera',
        ];

        $data = [];

        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'magnitude' => rand(30, 70) / 10, // 3.0 - 7.0
                'depth_km' => rand(1, 100),
                'latitude' => rand(-800000, 100000) / 100000,
                'longitude' => rand(12000000, 14000000) / 100000,
                'location_description' => $locations[array_rand($locations)],
                'felt_intensity' => rand(0, 1) ? 'II-III' : null,
                'potensi' => rand(0, 1) ? 'Tidak berpotensi tsunami' : null,
                'occurred_at' => Carbon::now()
                    ->subDays(rand(0, 7))
                    ->subMinutes(rand(0, 1440)),
                'shakemap_image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('earthquakes')->insert($data);
    }
}
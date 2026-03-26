<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LightningPeriod;
use App\Models\LightningMap;
use App\Models\LightningSubdistrictStat;
use App\Models\LightningDensityDaily;
use Carbon\Carbon;

class LightningSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('lightning_density_daily')->truncate();
        DB::table('lightning_subdistrict_stats')->truncate();
        DB::table('lightning_maps')->truncate();
        DB::table('lightning_periods')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // 🟦 1. Create Period
        $period = LightningPeriod::create([
            'year' => 2026,
            'month' => 3,
            'type' => 'dasarian',
            'label' => 'Dasarian I',
            'start_date' => '2026-03-01',
            'end_date' => '2026-03-10',
        ]);

        // 🟩 2. Create Map
        LightningMap::create([
            'period_id' => $period->id,
            'image_path' => 'maps/march_2026_dasarian_1.png',
            'source_updated_at' => now(),
        ]);

        // 🟨 3. Subdistrict Stats (Histogram)
        $subdistricts = [
            'Nabire',
            'Mimika',
            'Paniai',
            'Dogiyai',
            'Deiyai',
            'Intan Jaya',
            'Puncak',
            'Lanny Jaya'
        ];

        foreach ($subdistricts as $sub) {
            LightningSubdistrictStat::create([
                'period_id' => $period->id,
                'subdistrict' => $sub,
                'total_strikes' => rand(50, 1000),
            ]);
        }

        // 🟥 4. Daily Density (1–10 March)
        $start = Carbon::parse('2026-03-01');

        for ($i = 0; $i < 10; $i++) {
            $date = $start->copy()->addDays($i);

            LightningDensityDaily::create([
                'period_id' => $period->id,
                'date' => $date->format('Y-m-d'),
                'total_density' => rand(100, 1000),
            ]);
        }

        // 🔥 Optional: Force 1 peak day (biar realistis)
        LightningDensityDaily::where('period_id', $period->id)
            ->where('date', '2026-03-07')
            ->update(['total_density' => 1200]);
    }
}
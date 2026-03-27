<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LightningDensityDaily;
use App\Models\LightningMap;
use App\Models\LightningPeriod;
use App\Models\LightningSubdistrictStat;
use App\Models\Sunrise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeofisikaController extends Controller
{
    // ── SUNRISE (TTM) ─────────────────────────────────────────────────────────

    public function sunriseIndex(Request $request)
    {
        $query = Sunrise::query();

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('date', $request->month)->whereYear('date', $request->year);
        } elseif ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        $sunrises  = $query->orderBy('location')->orderBy('date')->paginate(30)->withQueryString();
        $locations = Sunrise::select('location')->distinct()->orderBy('location')->pluck('location');

        return view('admin.geofisika.sunrise-index', compact('sunrises', 'locations'));
    }

    public function sunriseCreate()
    {
        return view('admin.geofisika.sunrise-form', ['sunrise' => null]);
    }

    public function sunriseStore(Request $request)
    {
        $data = $request->validate([
            'location'         => 'required|string|max:100',
            'date'             => 'required|date',
            'dawn_time'        => 'required|date_format:H:i',
            'sunrise_time'     => 'required|date_format:H:i',
            'azimuth_sunrise'  => 'required|integer',
            'transit_time'     => 'required|date_format:H:i',
            'transit_altitude' => 'required|string|max:20',
            'sunset_time'      => 'required|date_format:H:i',
            'azimuth_sunset'   => 'required|integer',
            'dusk_time'        => 'required|date_format:H:i',
        ]);

        Sunrise::create($data);

        return redirect()->route('admin.sunrise.index')
            ->with('success', 'Data terbit-terbenam matahari berhasil ditambahkan.');
    }

    public function sunriseEdit(Sunrise $sunrise)
    {
        return view('admin.geofisika.sunrise-form', compact('sunrise'));
    }

    public function sunriseUpdate(Request $request, Sunrise $sunrise)
    {
        $data = $request->validate([
            'location'         => 'required|string|max:100',
            'date'             => 'required|date',
            'dawn_time'        => 'required|date_format:H:i',
            'sunrise_time'     => 'required|date_format:H:i',
            'azimuth_sunrise'  => 'required|integer',
            'transit_time'     => 'required|date_format:H:i',
            'transit_altitude' => 'required|string|max:20',
            'sunset_time'      => 'required|date_format:H:i',
            'azimuth_sunset'   => 'required|integer',
            'dusk_time'        => 'required|date_format:H:i',
        ]);

        $sunrise->update($data);

        return redirect()->route('admin.sunrise.index')
            ->with('success', 'Data terbit-terbenam matahari berhasil diperbarui.');
    }

    public function sunriseDestroy(Sunrise $sunrise)
    {
        $sunrise->delete();

        return redirect()->route('admin.sunrise.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    // ── LIGHTNING PERIOD ──────────────────────────────────────────────────────

    public function lightningIndex()
    {
        $periods = LightningPeriod::with('map')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderBy('type')
            ->paginate(20);

        return view('admin.geofisika.lightning-index', compact('periods'));
    }

    public function lightningCreate()
    {
        return view('admin.geofisika.lightning-form', ['period' => null]);
    }

    public function lightningStore(Request $request)
    {
        $data = $request->validate([
            'year'       => 'required|integer|min:2000|max:2100',
            'month'      => 'required|integer|min:1|max:12',
            'type'       => 'required|in:dasarian,bulanan,weekly',
            'label'      => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'map_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $period = LightningPeriod::create($data);

        if ($request->hasFile('map_image')) {
            $imagePath = $request->file('map_image')->store('lightning/maps', 'public');
            LightningMap::create([
                'period_id'         => $period->id,
                'image_path'        => $imagePath,
                'source_updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.lightning.index')
            ->with('success', 'Data periode petir berhasil ditambahkan.');
    }

    public function lightningEdit(LightningPeriod $lightning)
    {
        $lightning->load('map', 'subdistrictStats', 'densities');
        return view('admin.geofisika.lightning-form', ['period' => $lightning]);
    }

    public function lightningUpdate(Request $request, LightningPeriod $lightning)
    {
        $data = $request->validate([
            'year'       => 'required|integer|min:2000|max:2100',
            'month'      => 'required|integer|min:1|max:12',
            'type'       => 'required|in:dasarian,bulanan,weekly',
            'label'      => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'map_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $lightning->update($data);

        if ($request->hasFile('map_image')) {
            $imagePath = $request->file('map_image')->store('lightning/maps', 'public');

            if ($lightning->map) {
                Storage::disk('public')->delete($lightning->map->image_path);
                $lightning->map->update([
                    'image_path'        => $imagePath,
                    'source_updated_at' => now(),
                ]);
            } else {
                LightningMap::create([
                    'period_id'         => $lightning->id,
                    'image_path'        => $imagePath,
                    'source_updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.lightning.index')
            ->with('success', 'Data periode petir berhasil diperbarui.');
    }

    public function lightningDestroy(LightningPeriod $lightning)
    {
        if ($lightning->map) {
            Storage::disk('public')->delete($lightning->map->image_path);
        }
        $lightning->delete(); // cascades to map, stats, densities

        return redirect()->route('admin.lightning.index')
            ->with('success', 'Data periode petir berhasil dihapus.');
    }
}

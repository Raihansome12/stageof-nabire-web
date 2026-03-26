<?php

namespace App\Http\Controllers;

use App\Models\Sunrise;
use App\Models\Earthquake;
use App\Models\LightningMap;
use App\Models\LightningPeriod;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Terbit Terbenam - today's entries (show up to 8)
        $sunrises = Sunrise::whereDate('date', $today)
            ->take(8)
            ->get();

        // Latest earthquake
        $earthquake = Earthquake::latest('occurred_at')->first();

        // Latest lightning info
        $lightningMap = LightningMap::latest()->first();
        $lightningInfo = LightningPeriod::latest()->first();

        // Publications
        $buletin   = Publication::active()->buletin()->latest('published_at')->first();
        $beritas   = Publication::active()->berita()->latest('published_at')->take(2)->get();

        return view('pages.home', compact(
            'sunrises', 'earthquake', 'lightningMap', 'lightningInfo', 'buletin', 'beritas', 'today'
        ));
    }

    public function informasiGeofisika(Request $request)
    {
        $defaultRegion = 'Nabire';

        $ttmRegions = Sunrise::query()
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        if ($ttmRegions->isEmpty()) {
            $ttmRegions = collect([$defaultRegion]);
        } elseif (! $ttmRegions->contains($defaultRegion)) {
            $ttmRegions = $ttmRegions->prepend($defaultRegion)->sort()->values();
        }

        $month = (int) $request->input('month', date('n'));
        $year  = (int) $request->input('year', date('Y'));
        $month = max(1, min(12, $month));

        $locationInput = $request->input('location');
        if ($locationInput === null || $locationInput === '') {
            $location = $defaultRegion;
        } else {
            $location = $locationInput;
        }
        if (! $ttmRegions->contains($location)) {
            $location = $ttmRegions->contains($defaultRegion)
                ? $defaultRegion
                : $ttmRegions->first();
        }

        $sunrisesTable = Sunrise::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('location', $location)
            ->orderBy('date')
            ->get();

        return view('pages.informasi-geofisika', compact(
            'sunrisesTable', 'month', 'year', 'location', 'ttmRegions'
        ));
    }

    /**
     * API endpoint: return distinct locations matching a search string.
     * Route: GET /api/ttm/locations?q={query}
     */
    public function ttmLocations(Request $request)
    {
        $q = $request->input('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $locations = Sunrise::select('location')
            ->where('location', 'like', '%' . $q . '%')
            ->distinct()
            ->orderBy('location')
            ->limit(10)
            ->pluck('location');

        return response()->json($locations);
    }

    public function gempaBumi(Request $request)
    {
        $query = Earthquake::latest('occurred_at');

        // Filter: magnitude
        if ($request->filled('mag')) {
            if ($request->mag === 'gte5') {
                $query->where('magnitude', '>=', 5);
            } elseif ($request->mag === 'lt5') {
                $query->where('magnitude', '<', 5);
            }
        }

        // Filter: date range (max 30 days, enforced server-side)
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $from = Carbon::parse($request->date_from)->startOfDay();
            $to   = Carbon::parse($request->date_to)->endOfDay();
            if ($from->diffInDays($to) <= 30 && $to->gte($from)) {
                $query->whereBetween('occurred_at', [$from, $to]);
            }
        } elseif ($request->filled('date_from')) {
            $query->where('occurred_at', '>=', Carbon::parse($request->date_from)->startOfDay());
        } elseif ($request->filled('date_to')) {
            $query->where('occurred_at', '<=', Carbon::parse($request->date_to)->endOfDay());
        }

        $earthquakes = $query->get();

        $eqMapData = $earthquakes->values()->map(function ($eq, $i) {
            return [
                'index' => $i,
                'lat'   => (float) $eq->latitude,
                'lng'   => (float) $eq->longitude,
                'mag'   => (float) $eq->magnitude,
                'loc'   => $eq->location_description,
                'depth' => $eq->depth_km,
                'time'  => $eq->occurred_at->format('d M Y H:i:s'),
                'mmi'   => $eq->felt_intensity ?? null,
            ];
        })->toArray();

        return view('pages.gempa-bumi', compact('earthquakes', 'eqMapData'));
    }

    public function petirData(Request $request)
    {
        $month    = (int) $request->input('month', date('n'));
        $year     = (int) $request->input('year',  date('Y'));
        $type     = $request->input('type', 'dasarian'); // 'dasarian' | 'bulanan'
        $dasarian = (int) $request->input('dasarian', 1);
    
        $month = max(1, min(12, $month));
    
        // Build the query for the matching LightningPeriod
        $query = \App\Models\LightningPeriod::where('year', $year)
            ->where('month', $month);
    
        if ($type === 'bulanan') {
            $query->where('type', 'bulanan');
        } else {
            // Dasarian type — 'dasarian' stored in the type column,
            // and label/start_date differentiates I / II / III.
            // Assumes: label like 'Dasarian I', 'Dasarian II', 'Dasarian III'
            // OR you can use start_date ranges based on dasarian number.
            $query->where('type', 'dasarian');
    
            // Map dasarian number to label
            $dasarianLabel = ['Dasarian I', 'Dasarian II', 'Dasarian III'][$dasarian - 1] ?? 'Dasarian I';
            $query->where('label', 'like', '%' . $dasarianLabel . '%');
        }
    
        $period = $query->with(['map', 'subdistrictStats', 'densities'])->first();
    
        if (! $period) {
            return response()->json(['period' => null], 200);
        }
    
        // Format map URL
        $mapUrl = null;
        if ($period->map && $period->map->image_path) {
            $mapUrl = asset('storage/' . $period->map->image_path);
        }
    
        // Format updated_at
        $mapUpdatedAt = null;
        if ($period->map && $period->map->source_updated_at) {
            $mapUpdatedAt = \Carbon\Carbon::parse($period->map->source_updated_at)
                ->locale('id')
                ->isoFormat('dddd, D MMMM YYYY');
        }
    
        // Subdistrict stats — sorted by total_strikes desc
        $subdistrictStats = $period->subdistrictStats
            ->sortByDesc('total_strikes')
            ->values()
            ->map(fn($s) => [
                'subdistrict'  => $s->subdistrict,
                'total_strikes' => (int) $s->total_strikes,
            ]);
    
        // Daily densities — sorted by date asc
        $dailyDensities = $period->densities
            ->sortBy('date')
            ->values()
            ->map(fn($d) => [
                'date'          => \Carbon\Carbon::parse($d->date)->format('d/m'),
                'total_density' => (float) $d->total_density,
            ]);
    
        return response()->json([
            'period' => [
                'id'         => $period->id,
                'year'       => $period->year,
                'month'      => $period->month,
                'type'       => $period->type,
                'label'      => $period->label,
                'start_date' => $period->start_date,
                'end_date'   => $period->end_date,
            ],
            'map_url'           => $mapUrl,
            'map_updated_at'    => $mapUpdatedAt,
            'subdistrict_stats' => $subdistrictStats,
            'daily_densities'   => $dailyDensities,
        ]);
    }

    public function publikasi()
    {
        $buletins = Publication::active()->buletin()->latest('published_at')->paginate(6);
        $beritas  = Publication::active()->berita()->latest('published_at')->paginate(6);
        return view('pages.publikasi', compact('buletins', 'beritas'));
    }

    public function profil()
    {
        return view('pages.profil');
    }

    public function informasiPublik()
    {
        return view('pages.informasi-publik');
    }

    public function layananMasyarakat()
    {
        return view('pages.layanan-masyarakat');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Earthquake;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EarthquakeController extends Controller
{
    public function index(Request $request)
    {
        $query = Earthquake::query();

        // if ($request->filled('search')) {
        //     $query->where('location_description', 'like', '%' . $request->search . '%');
        // }
        $from = null;
        $to   = null;

        if ($request->filled('start_date')) {
            $from = Carbon::parse($request->start_date, 'Asia/Jayapura')
                ->startOfDay()
                ->setTimezone('UTC');
        }

        if ($request->filled('end_date')) {
            $to = Carbon::parse($request->end_date, 'Asia/Jayapura')
                ->endOfDay()
                ->setTimezone('UTC');
        }

        if ($from && $to) {
            $query->whereBetween('occurred_at', [$from, $to]);
        } elseif ($from) {
            $query->where('occurred_at', '>=', $from);
        } elseif ($to) {
            $query->where('occurred_at', '<=', $to);
        }
        
        if ($request->filled('mag')) {
            if ($request->mag === 'gte5') $query->where('magnitude', '>=', 5);
            elseif ($request->mag === 'lt5') $query->where('magnitude', '<', 5);
        }
        if ($request->filled('year')) {
            $query->whereYear('occurred_at', $request->year);
        }

        $earthquakes = $query->latest('occurred_at')->paginate(20)->withQueryString();

        return view('admin.gempa.index', compact('earthquakes'));
    }

    public function create()
    {
        return view('admin.gempa.form', ['earthquake' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Earthquake::create($data);

        return redirect()->route('admin.gempa.index')
            ->with('success', 'Data gempa bumi berhasil ditambahkan.');
    }

    public function edit(Earthquake $gempa)
    {
        return view('admin.gempa.form', ['earthquake' => $gempa]);
    }

    public function update(Request $request, Earthquake $gempa)
    {
        $data = $this->validated($request);
        $gempa->update($data);

        return redirect()->route('admin.gempa.index')
            ->with('success', 'Data gempa bumi berhasil diperbarui.');
    }

    public function destroy(Earthquake $gempa)
    {
        $gempa->delete();

        return redirect()->route('admin.gempa.index')
            ->with('success', 'Data gempa bumi berhasil dihapus.');
    }

    // ── Bulk delete ───────────────────────────────────────────────────────────

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:earthquakes,id',
        ]);

        Earthquake::whereIn('id', $request->ids)->delete();

        $count = count($request->ids);

        return redirect()->route('admin.gempa.index')
            ->with('success', "{$count} data gempa bumi berhasil dihapus.");
    }

    // ── Shared validation ─────────────────────────────────────────────────────

    private function validated(Request $request): array
    {
        return $request->validate([
            'magnitude'            => 'required|numeric|min:0|max:10',
            'depth_km'             => 'required|integer|min:0',
            'latitude'             => 'required|numeric|between:-90,90',
            'longitude'            => 'required|numeric|between:-180,180',
            'location_description' => 'required|string|max:500',
            'felt_intensity'       => 'nullable|string|max:500',
            'potensi'              => 'nullable|string|max:500',
            'occurred_at'          => 'required|date',
            'shakemap_image'       => 'nullable|url|max:1000',
        ]);
    }
}

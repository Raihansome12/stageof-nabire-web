<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LightningDensityDaily;
use App\Models\LightningMap;
use App\Models\LightningPeriod;
use App\Models\LightningSubdistrictStat;
use App\Models\Sunrise;
use Carbon\Carbon;
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

        $sunrises  = $query->orderBy('location')->orderBy('date')->paginate(31)->withQueryString();
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

    // ── SUNRISE CSV IMPORT ───────────────────────────────────────────────────

    public function sunriseImportForm()
    {
        return view('admin.geofisika.sunrise-import');
    }

    public function sunriseTemplate()
    {
        // Build a sample CSV for the current month with correct column headers
        $month    = now()->month;
        $year     = now()->year;
        $daysInMonth = now()->daysInMonth;

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_ttm_' . now()->format('Y_m') . '.csv"',
        ];

        $callback = function () use ($month, $year, $daysInMonth) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fputs($handle, "ï»¿");

            // Header row
            fputcsv($handle, [
                'location',
                'date',
                'dawn_time',
                'sunrise_time',
                'azimuth_sunrise',
                'transit_time',
                'transit_altitude',
                'sunset_time',
                'azimuth_sunset',
                'dusk_time',
            ]);

            // Sample rows for every day of the month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                fputcsv($handle, [
                    'Nabire',          // location
                    $date,             // date  YYYY-MM-DD
                    '05:10',           // dawn_time
                    '05:32',           // sunrise_time
                    '65',              // azimuth_sunrise (degrees)
                    '11:45',           // transit_time
                    '75.3',            // transit_altitude
                    '17:58',           // sunset_time
                    '295',             // azimuth_sunset
                    '18:20',           // dusk_time
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function sunriseImport(Request $request)
    {
        $request->validate([
            'csv_file'       => 'required|file|mimes:csv,txt|max:2048',
            'conflict_mode'  => 'required|in:skip,replace',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // Strip UTF-8 BOM if present
        $raw = file_get_contents($path);
        if (substr($raw, 0, 3) === "ï»¿") {
            $raw = substr($raw, 3);
        }

        $lines = array_filter(explode("
", str_replace("
", "
", $raw)));
        $lines = array_values($lines);

        if (count($lines) < 2) {
            return back()->withErrors(['csv_file' => 'File CSV kosong atau hanya berisi header.']);
        }

        // Parse header
        $header = str_getcsv(array_shift($lines));
        $header = array_map(function ($h) {
            $h = preg_replace('/^\xEF\xBB\xBF/', '', $h); // remove BOM
            return strtolower(trim($h));
        }, $header);

        $required = ['location','date','dawn_time','sunrise_time','azimuth_sunrise',
                     'transit_time','transit_altitude','sunset_time','azimuth_sunset','dusk_time'];

        $missing = array_diff($required, $header);
        if ($missing) {
            return back()->withErrors([
                'csv_file' => 'Kolom tidak lengkap. Kolom yang hilang: ' . implode(', ', $missing)
            ]);
        }

        $colIndex = array_flip($header);

        $inserted = 0;
        $skipped  = 0;
        $errors   = [];
        $rowNum   = 1;

        foreach ($lines as $line) {
            $rowNum++;
            $line = trim($line);
            if ($line === '') continue;

            $cols = str_getcsv($line);
            $cols = array_map('trim', $cols);

            // Map columns
            try {
                $location        = $cols[$colIndex['location']]        ?? '';
                $date            = $cols[$colIndex['date']]            ?? '';
                $dawnTime        = $cols[$colIndex['dawn_time']]       ?? '';
                $sunriseTime     = $cols[$colIndex['sunrise_time']]    ?? '';
                $azimuthSunrise  = $cols[$colIndex['azimuth_sunrise']] ?? '';
                $transitTime     = $cols[$colIndex['transit_time']]    ?? '';
                $transitAlt      = $cols[$colIndex['transit_altitude']]?? '';
                $sunsetTime      = $cols[$colIndex['sunset_time']]     ?? '';
                $azimuthSunset   = $cols[$colIndex['azimuth_sunset']]  ?? '';
                $duskTime        = $cols[$colIndex['dusk_time']]       ?? '';
            } catch (\Exception $e) {
                $errors[] = "Baris {$rowNum}: Jumlah kolom tidak sesuai.";
                continue;
            }

            // Basic validation
            if (!$location || !$date) {
                $errors[] = "Baris {$rowNum}: lokasi atau tanggal kosong.";
                continue;
            }

            // Validate date
            try {
                // Try multiple formats
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                    // Format: YYYY-MM-DD
                    $parsedDate = Carbon::createFromFormat('Y-m-d', $date);
                } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                    // Format: DD/MM/YYYY
                    $parsedDate = Carbon::createFromFormat('d/m/Y', $date);
                } else {
                    throw new \Exception();
                }
            
                // Normalize to DB format
                $date = $parsedDate->format('Y-m-d');
            
            } catch (\Exception $e) {
                $errors[] = "Baris {$rowNum}: format tanggal tidak valid ({$date}). Gunakan YYYY-MM-DD atau DD/MM/YYYY.";
                continue;
            }

            // Validate times (HH:MM or HH:MM:SS)
            $timeFields = [
                'dawn_time'    => $dawnTime,
                'sunrise_time' => $sunriseTime,
                'transit_time' => $transitTime,
                'sunset_time'  => $sunsetTime,
                'dusk_time'    => $duskTime,
            ];
            $timeError = false;
            foreach ($timeFields as $fieldName => $timeVal) {
                // Accept HH:MM or HH:MM:SS
                if (!preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $timeVal)) {
                    $errors[] = "Baris {$rowNum}: format waktu tidak valid untuk {$fieldName} ({$timeVal}).";
                    $timeError = true;
                }
            }
            if ($timeError) continue;

            // Normalize time to HH:MM
            foreach (['dawn_time' => &$dawnTime, 'sunrise_time' => &$sunriseTime,
                      'transit_time' => &$transitTime, 'sunset_time' => &$sunsetTime,
                      'dusk_time' => &$duskTime] as $k => &$v) {
                $v = substr($v, 0, 5); // take HH:MM
            }
            unset($v);

            if (!is_numeric($azimuthSunrise) || !is_numeric($azimuthSunset)) {
                $errors[] = "Baris {$rowNum}: azimuth harus berupa angka.";
                continue;
            }

            // Check if record exists (same location + date)
            $existing = Sunrise::where('location', $location)
                ->whereDate('date', $date)
                ->first();

            if ($existing) {
                if ($request->conflict_mode === 'skip') {
                    $skipped++;
                    continue;
                }
                // replace
                $existing->update([
                    'dawn_time'        => $dawnTime,
                    'sunrise_time'     => $sunriseTime,
                    'azimuth_sunrise'  => (int) $azimuthSunrise,
                    'transit_time'     => $transitTime,
                    'transit_altitude' => $transitAlt,
                    'sunset_time'      => $sunsetTime,
                    'azimuth_sunset'   => (int) $azimuthSunset,
                    'dusk_time'        => $duskTime,
                ]);
                $inserted++;
            } else {
                Sunrise::create([
                    'location'         => $location,
                    'date'             => $date,
                    'dawn_time'        => $dawnTime,
                    'sunrise_time'     => $sunriseTime,
                    'azimuth_sunrise'  => (int) $azimuthSunrise,
                    'transit_time'     => $transitTime,
                    'transit_altitude' => $transitAlt,
                    'sunset_time'      => $sunsetTime,
                    'azimuth_sunset'   => (int) $azimuthSunset,
                    'dusk_time'        => $duskTime,
                ]);
                $inserted++;
            }
        }

        $message = "Import selesai: {$inserted} baris berhasil diimpor";
        if ($skipped > 0) $message .= ", {$skipped} dilewati (sudah ada)";
        if ($errors)      $message .= ", " . count($errors) . " baris gagal";

        $result = [
            'inserted' => $inserted,
            'skipped'  => $skipped,
            'errors'   => $errors,
            'message'  => $message,
        ];

        return redirect()->route('admin.sunrise.index')
            ->with('import_result', $result);
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

    // ── SYNC SUBDISTRICT STATS ────────────────────────────────────────────────

    public function syncStats(Request $request, LightningPeriod $lightning)
    {
        $rows = $request->input('stats', []);

        // Collect submitted IDs (empty string = new row)
        $submittedIds = collect($rows)
            ->pluck('id')
            ->filter(fn($id) => $id !== '' && $id !== null)
            ->map(fn($id) => (int) $id)
            ->all();

        // Delete rows that were removed in the UI
        $lightning->subdistrictStats()
            ->whereNotIn('id', $submittedIds)
            ->delete();

        // Upsert each submitted row
        foreach ($rows as $row) {
            $subdistrict   = trim($row['subdistrict']   ?? '');
            $total_strikes = (int) ($row['total_strikes'] ?? 0);

            if ($subdistrict === '') continue;

            $id = isset($row['id']) && $row['id'] !== '' ? (int) $row['id'] : null;

            if ($id && $lightning->subdistrictStats()->where('id', $id)->exists()) {
                $lightning->subdistrictStats()->where('id', $id)->update([
                    'subdistrict'   => $subdistrict,
                    'total_strikes' => $total_strikes,
                ]);
            } else {
                $lightning->subdistrictStats()->create([
                    'subdistrict'   => $subdistrict,
                    'total_strikes' => $total_strikes,
                ]);
            }
        }

        return redirect()->route('admin.lightning.edit', $lightning)
            ->with('success', 'Data kecamatan berhasil disimpan.');
    }

    // ── SYNC DAILY DENSITIES ──────────────────────────────────────────────────

    public function syncDensities(Request $request, LightningPeriod $lightning)
    {
        $rows = $request->input('densities', []);

        $submittedIds = collect($rows)
            ->pluck('id')
            ->filter(fn($id) => $id !== '' && $id !== null)
            ->map(fn($id) => (int) $id)
            ->all();

        // Delete rows removed in the UI
        $lightning->densities()
            ->whereNotIn('id', $submittedIds)
            ->delete();

        // Upsert each submitted row
        foreach ($rows as $row) {
            $date          = $row['date']          ?? null;
            $total_density = $row['total_density'] ?? 0;

            if (!$date) continue;

            $id = isset($row['id']) && $row['id'] !== '' ? (int) $row['id'] : null;

            if ($id && $lightning->densities()->where('id', $id)->exists()) {
                $lightning->densities()->where('id', $id)->update([
                    'date'          => $date,
                    'total_density' => (float) $total_density,
                ]);
            } else {
                // Use updateOrCreate to respect the unique(period_id, date) constraint
                $lightning->densities()->updateOrCreate(
                    ['date' => $date],
                    ['total_density' => (float) $total_density]
                );
            }
        }

        return redirect()->route('admin.lightning.edit', $lightning)
            ->with('success', 'Data kerapatan harian berhasil disimpan.');
    }

}
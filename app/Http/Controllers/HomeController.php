<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\InformasiPublik;
use App\Models\PermohonanData;
use App\Models\Staff;
use App\Models\Sunrise;
use App\Models\Earthquake;
use App\Models\LightningMap;
use App\Models\LightningPeriod;
use App\Models\Publication;
use App\Models\HilalBulletin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        // Terbit Terbenam
        $sunrises = Sunrise::whereDate('date', $today)->take(8)->get();

        // --- EARTHQUAKE LOGIC ---
        $twentyFourHoursAgo = Carbon::now()->subHours(24);
        
        // Step 1: Look for an earthquake WITH a ShakeMap that occurred in the last 24 hours
        $earthquake = Earthquake::where('occurred_at', '>=', $twentyFourHoursAgo)
            ->whereNotNull('shakemap_image')
            ->where('shakemap_image', '!=', '')
            ->latest('occurred_at')
            ->first();

        // Step 2: If no ShakeMap earthquake exists in the last 24 hours, 
        // just get the absolute latest earthquake (even if it has no ShakeMap)
        if (!$earthquake) {
            $earthquake = Earthquake::latest('occurred_at')->first();
        }

        // Step 3: Set variables for your Blade template so it knows how to display it
        $hasShakemap = $earthquake && !empty($earthquake->shakemap_image);
        // Only true if there is NO Shakemap, AND we have the required map coordinates/data
        $hasGeoData = $earthquake 
            && !$hasShakemap
            && $earthquake->latitude !== null 
            && $earthquake->longitude !== null 
            && $earthquake->magnitude !== null;

        // Latest lightning info
        $lightningMap = LightningMap::latest()->first();
        $lightningInfo = LightningPeriod::latest()->first();

        // Publications
        $buletin   = Publication::active()->buletin()->latest('published_at')->first();
        $beritas   = InformasiPublik::active()->berita()->latest('published_at')->take(2)->get();

        return view('pages.home', compact(
            'sunrises', 
            'earthquake', 
            'hasShakemap', 
            'hasGeoData',  
            'lightningMap', 
            'lightningInfo', 
            'buletin', 
            'beritas', 
            'today'
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

        // ── Gempa Bumi Terkini (merged in as its own tab) ──────────────────
        [$earthquakes, $eqMapData] = $this->buildEarthquakeData($request);

        // ── Informasi Hilal (merged in as its own tab) ─────────────────────
        $hilals = HilalBulletin::active()->latest('published_at')->paginate(10, ['*'], 'hilal_page');

        return view('pages.informasi-geofisika', compact(
            'sunrisesTable', 'month', 'year', 'location', 'ttmRegions',
            'earthquakes', 'eqMapData', 'hilals'
        ));
    }

    /**
     * Build the filtered earthquake list + map payload shared by the
     * "Gempa Bumi Terkini" tab on the Informasi Geofisika page.
     */
    private function buildEarthquakeData(Request $request): array
    {
        $query = Earthquake::latest('occurred_at');

        if ($request->filled('mag')) {
            if ($request->mag === 'gte5') {
                $query->where('magnitude', '>=', 5);
            } elseif ($request->mag === 'lt5') {
                $query->where('magnitude', '<', 5);
            }
        }

        $from = null;
        $to   = null;

        if ($request->filled('date_from')) {
            $from = Carbon::parse($request->date_from, 'Asia/Jayapura')
                ->startOfDay()
                ->setTimezone('UTC');
        }

        if ($request->filled('date_to')) {
            $to = Carbon::parse($request->date_to, 'Asia/Jayapura')
                ->endOfDay()
                ->setTimezone('UTC');
        }

        if ($from && $to) {
            if ($from->diffInDays($to) <= 30 && $to->gte($from)) {
                $query->whereBetween('occurred_at', [$from, $to]);
            }
        } elseif ($from) {
            $query->where('occurred_at', '>=', $from);
        } elseif ($to) {
            $query->where('occurred_at', '<=', $to);
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
                'time'  => $eq->occurred_at->copy()->setTimezone('Asia/Jayapura')->format('d M Y H:i:s'),
                'mmi'   => $eq->felt_intensity ?? null,
            ];
        })->toArray();

        return [$earthquakes, $eqMapData];
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
        $buletins = Publication::active()->buletin()->latest('published_at')->paginate(10);
        $artikels = \App\Models\Artikel::active()->latest('published_at')->paginate(9);
        return view('pages.publikasi', compact('buletins', 'artikels'));
    }

    public function profil()
    {
        $staffKepala     = Staff::active()->kepala()->orderBy('sort_order')->get();
        $staffFungsional = Staff::active()->fungsional()->orderBy('sort_order')->get();
        $staffPpnpn      = Staff::active()->ppnpn()->orderBy('sort_order')->get();
        return view('pages.profil', compact('staffKepala', 'staffFungsional', 'staffPpnpn'));
    }

    public function informasiPublik()
    {
        $beritas     = InformasiPublik::active()->berita()->latest('published_at')->paginate(9);
        $pengumumans = InformasiPublik::active()->pengumuman()->latest('published_at')->paginate(9);
        return view('pages.informasi-publik', compact('beritas', 'pengumumans'));
    }

    /**
     * Detail page for a single Artikel — lets visitors read the full content.
     */
    public function artikelShow(Artikel $artikel)
    {
        $isAdmin = auth()->check() && auth()->user()->is_admin;
        abort_unless($artikel->is_active || $isAdmin, 404);

        $related = Artikel::active()
            ->where('id', '!=', $artikel->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.artikel-show', compact('artikel', 'related'));
    }

    /**
     * Detail page for a single Berita/Pengumuman — lets visitors read the full content.
     */
    public function informasiPublikShow(InformasiPublik $informasiPublik)
    {
        $isAdmin = auth()->check() && auth()->user()->is_admin;
        abort_unless($informasiPublik->is_active || $isAdmin, 404);

        $related = InformasiPublik::active()
            ->where('type', $informasiPublik->type)
            ->where('id', '!=', $informasiPublik->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $isBerita = $informasiPublik->type === 'berita';
        $label    = $isBerita ? 'Berita' : 'Pengumuman';
        $accent   = $isBerita ? 'bmkg-teal' : 'amber-600';
        $icon     = $isBerita ? '📰' : '📢';

        return view('pages.informasi-publik-show', compact('informasiPublik', 'related', 'isBerita', 'label', 'accent', 'icon'));
    }

    // ── Layanan Masyarakat ────────────────────────────────────────────────────
    public function layananMasyarakat()
    {
        return view('pages.layanan-masyarakat');
    }

    public function storeSuggestion(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ], [
            'comment.required' => 'Komentar wajib diisi.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        \App\Models\Suggestion::create($validated);

        return redirect()->route('layanan-masyarakat')->with('suggestion_success', 'Terima kasih, saran Anda telah berhasil disimpan.');
    }

    /**
     * Handle form submission for Permohonan Data.
     * Saves to DB, then sends email + WhatsApp notification.
     */
    public function layananMasyarakatStore(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'nik'               => 'nullable|string|max:16',
            'email'             => 'nullable|email|max:255',
            'no_hp'             => 'required|string|max:20',
            'instansi'          => 'required|string|max:255',
            'alamat'            => 'nullable|string|max:1000',
            'jenis_permohonan'  => 'required|in:pnbp,nol',
            'jenis_data'        => 'required|string|max:255',
            'lingkup_kegiatan'  => 'nullable|string|max:255',
            'file_surat_permohonan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_surat_pengantar'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_surat_pernyataan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_proposal'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'nama_lengkap.required'     => 'Nama lengkap wajib diisi.',
            'no_hp.required'            => 'Nomor HP wajib diisi.',
            'instansi.required'         => 'Instansi wajib diisi.',
            'jenis_permohonan.required' => 'Jenis permohonan wajib dipilih.',
            'jenis_data.required'       => 'Jenis data yang diminta wajib diisi.',
        ]);

        // Store uploaded files
        foreach (['file_surat_permohonan', 'file_surat_pengantar', 'file_surat_pernyataan', 'file_proposal'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('permohonan-data', 'public');
            }
        }

        $permohonan = PermohonanData::create($validated);

        // ── Send Email Notification ───────────────────────────────────────────
        $this->sendEmailNotification($permohonan);

        $phone = env('OFFICE_WA_NUMBER'); 
        
        $message = "*Permohonan Data Baru* (#{$permohonan->id})\n\n"
            . "Halo Admin, saya telah mengirimkan permohonan data via website dengan detail:\n"
            . "*{$permohonan->nama_lengkap}*\n"
            . "*{$permohonan->instansi}*\n"
            . "{$permohonan->no_hp}\n\n"
            . "*{$permohonan->labelJenisPermohonan()}*\n"
            . "Jenis Data: {$permohonan->jenis_data}\n\n"
            . "Mohon info selanjutnya. Terima kasih.";

        $url = "https://wa.me/" . $phone . "?text=" . urlencode($message);

        // Redirect user directly to WhatsApp
        return redirect()->away($url);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function sendEmailNotification(PermohonanData $p): void
    {
        $officeEmail = config('mail.office_email', env('OFFICE_EMAIL', 'stageof.nabire@bmkg.go.id'));

        $subject = "[Permohonan Data] {$p->labelJenisPermohonan()} – {$p->nama_lengkap} ({$p->instansi})";

        $body = "
Permohonan Data Baru Masuk
==========================
ID Permohonan : #{$p->id}
Tanggal       : {$p->created_at->format('d M Y, H:i')} WIT

IDENTITAS PEMOHON
-----------------
Nama Lengkap  : {$p->nama_lengkap}
NIK           : " . ($p->nik ?: '-') . "
Instansi      : {$p->instansi}
No. HP        : {$p->no_hp}
Email         : " . ($p->email ?: '-') . "
Alamat        : " . ($p->alamat ?: '-') . "

DETAIL PERMOHONAN
-----------------
Jenis Permohonan : {$p->labelJenisPermohonan()}
Jenis Data       : {$p->jenis_data}
Lingkup Kegiatan : " . ($p->lingkup_kegiatan ?: '-') . "

Dokumen terlampir: " . ($p->file_surat_permohonan ? 'Ya' : 'Tidak') . "

Kelola permohonan ini di panel admin.
        ";

        try {
            Mail::raw($body, function ($message) use ($officeEmail, $subject) {
                $message->to($officeEmail)->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email notifikasi permohonan: ' . $e->getMessage());
        }
    }
}
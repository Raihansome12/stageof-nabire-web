<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\PublikasiController;
use App\Http\Controllers\Admin\GeofisikaController;
use App\Http\Controllers\Admin\EarthquakeController;
use App\Http\Controllers\Admin\InformasiPublikController;
use App\Http\Controllers\Admin\PermohonanDataController;
use App\Http\Controllers\Admin\SuggestionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ApiTokenController;
use App\Http\Controllers\Admin\HilalController;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/publikasi', [HomeController::class, 'publikasi'])->name('publikasi');
Route::get('/gempa-bumi', function () {
    return redirect()->route('informasi-geofisika', ['tab' => 'gempa']);
})->name('gempa-bumi');
Route::get('/gempa-bumi/{earthquake}', [HomeController::class, 'earthquakeShow'])->name('earthquake.show');
Route::get('/informasi-publik', [HomeController::class, 'informasiPublik'])->name('informasi-publik');
Route::get('/artikel/{artikel}', [HomeController::class, 'artikelShow'])->name('artikel.show');
Route::get('/informasi-publik/{informasiPublik}', [HomeController::class, 'informasiPublikShow'])->name('informasi-publik.show');

// Layanan Masyarakat — GET (display) + POST (submit form)
Route::get('/layanan-masyarakat', [HomeController::class, 'layananMasyarakat'])->name('layanan-masyarakat');
Route::post('/layanan-masyarakat', [HomeController::class, 'layananMasyarakatStore'])->name('layanan-masyarakat.store');
Route::post('/layanan-masyarakat/saran', [HomeController::class, 'storeSuggestion'])->name('layanan-masyarakat.saran.store');

// Informasi Geofisika (TTM + Petir)
Route::get('/informasi-geofisika', [HomeController::class, 'informasiGeofisika'])
    ->name('informasi-geofisika');

// API: autocomplete lokasi TTM
Route::get('/api/ttm/locations', [HomeController::class, 'ttmLocations'])
    ->name('api.ttm.locations');

// API: petir
Route::get('/api/petir/data', [HomeController::class, 'petirData'])->name('petir.data');

// ── Auth routes ───────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    });
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// ── Admin routes ──────────────────────────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Staff (Profil)
        Route::resource('staff', StaffController::class)->except(['show']);
        Route::delete('staff', [StaffController::class, 'bulkDestroy'])->name('staff.bulk-destroy');

        // Buletin
        Route::prefix('buletin')->name('buletin.')->group(function () {
            Route::get('/',               [PublikasiController::class, 'buletinIndex'])   ->name('index');
            Route::get('/create',         [PublikasiController::class, 'buletinCreate'])  ->name('create');
            Route::post('/',              [PublikasiController::class, 'buletinStore'])   ->name('store');
            Route::get('/{buletin}/edit', [PublikasiController::class, 'buletinEdit'])   ->name('edit');
            Route::put('/{buletin}',      [PublikasiController::class, 'buletinUpdate']) ->name('update');
            Route::delete('/{buletin}',   [PublikasiController::class, 'buletinDestroy'])->name('destroy');
            Route::delete('/',              [PublikasiController::class, 'buletinBulkDestroy'])->name('bulk-destroy');
        });

        // Artikel
        Route::prefix('artikel')->name('artikel.')->group(function () {
            Route::get('/',               [PublikasiController::class, 'artikelIndex'])   ->name('index');
            Route::get('/create',         [PublikasiController::class, 'artikelCreate'])  ->name('create');
            Route::post('/',              [PublikasiController::class, 'artikelStore'])   ->name('store');
            Route::get('/{artikel}/edit', [PublikasiController::class, 'artikelEdit'])   ->name('edit');
            Route::put('/{artikel}',      [PublikasiController::class, 'artikelUpdate']) ->name('update');
            Route::delete('/{artikel}',   [PublikasiController::class, 'artikelDestroy'])->name('destroy');
            Route::delete('/',              [PublikasiController::class, 'artikelBulkDestroy'])->name('bulk-destroy');
        });

        // Geofisika — Terbit/Terbenam Matahari
        Route::prefix('sunrise')->name('sunrise.')->group(function () {
            Route::get('/',               [GeofisikaController::class, 'sunriseIndex'])   ->name('index');
            Route::get('/create',         [GeofisikaController::class, 'sunriseCreate'])  ->name('create');
            Route::post('/',              [GeofisikaController::class, 'sunriseStore'])   ->name('store');
            Route::get('/{sunrise}/edit', [GeofisikaController::class, 'sunriseEdit'])   ->name('edit');
            Route::put('/{sunrise}',      [GeofisikaController::class, 'sunriseUpdate']) ->name('update');
            Route::delete('/{sunrise}',   [GeofisikaController::class, 'sunriseDestroy'])->name('destroy');
            Route::delete('/',              [GeofisikaController::class, 'sunriseBulkDestroy'])->name('bulk-destroy');
            // CSV import
            Route::get('/import',             [GeofisikaController::class, 'sunriseImportForm'])->name('import');
            Route::post('/import',            [GeofisikaController::class, 'sunriseImport'])    ->name('import.store');
            Route::get('/template/download',  [GeofisikaController::class, 'sunriseTemplate']) ->name('template');
        });

        // Geofisika — Peta Sambaran Petir
        Route::prefix('lightning')->name('lightning.')->group(function () {
            Route::get('/',                [GeofisikaController::class, 'lightningIndex'])   ->name('index');
            Route::get('/create',          [GeofisikaController::class, 'lightningCreate'])  ->name('create');
            Route::post('/',               [GeofisikaController::class, 'lightningStore'])   ->name('store');
            Route::get('/{lightning}/edit',[GeofisikaController::class, 'lightningEdit'])   ->name('edit');
            Route::put('/{lightning}',     [GeofisikaController::class, 'lightningUpdate']) ->name('update');
            Route::delete('/{lightning}',  [GeofisikaController::class, 'lightningDestroy'])->name('destroy');
            Route::delete('/',               [GeofisikaController::class, 'lightningBulkDestroy'])->name('bulk-destroy');
            Route::put('/{lightning}/stats',     [GeofisikaController::class, 'syncStats'])    ->name('stats.sync');
            Route::put('/{lightning}/densities', [GeofisikaController::class, 'syncDensities'])->name('densities.sync');
        });

        // Geofisika — Informasi Hilal
        Route::prefix('hilal')->name('hilal.')->group(function () {
            Route::get('/',              [HilalController::class, 'index'])   ->name('index');
            Route::get('/create',        [HilalController::class, 'create'])  ->name('create');
            Route::post('/',             [HilalController::class, 'store'])   ->name('store');
            Route::get('/{hilal}/edit',  [HilalController::class, 'edit'])    ->name('edit');
            Route::put('/{hilal}',       [HilalController::class, 'update'])  ->name('update');
            Route::delete('/{hilal}',    [HilalController::class, 'destroy']) ->name('destroy');
            Route::delete('/',           [HilalController::class, 'bulkDestroy'])->name('bulk-destroy');
        });

        // Informasi Publik
        Route::resource('informasi-publik', InformasiPublikController::class)
            ->except(['show'])
            ->parameter('informasi-publik', 'informasiPublik');
        Route::delete('informasi-publik', [InformasiPublikController::class, 'bulkDestroy'])->name('informasi-publik.bulk-destroy');

        // Gempa Bumi
        Route::prefix('gempa')->name('gempa.')->group(function () {
            Route::get('/',              [EarthquakeController::class, 'index'])       ->name('index');
            Route::get('/create',        [EarthquakeController::class, 'create'])      ->name('create');
            Route::post('/',             [EarthquakeController::class, 'store'])       ->name('store');
            Route::get('/{gempa}/edit',  [EarthquakeController::class, 'edit'])        ->name('edit');
            Route::put('/{gempa}',       [EarthquakeController::class, 'update'])      ->name('update');
            Route::delete('/{gempa}',    [EarthquakeController::class, 'destroy'])     ->name('destroy');
            Route::delete('/',           [EarthquakeController::class, 'bulkDestroy']) ->name('bulk-destroy');
        });

        // ── Permohonan Data Masyarakat ────────────────────────────────────────
        Route::prefix('permohonan-data')->name('permohonan-data.')->group(function () {
            Route::get('/',                        [PermohonanDataController::class, 'index'])       ->name('index');
            Route::get('/{permohonanData}',        [PermohonanDataController::class, 'show'])        ->name('show');
            Route::get('/{permohonanData}/pdf',            [PermohonanDataController::class, 'pdfDetail'])  ->name('pdf-detail');
            Route::get('/{permohonanData}/pdf-selesai',     [PermohonanDataController::class, 'pdfSelesai']) ->name('pdf-selesai');
            Route::put('/{permohonanData}',        [PermohonanDataController::class, 'update'])      ->name('update');
            Route::delete('/{permohonanData}',     [PermohonanDataController::class, 'destroy'])     ->name('destroy');
            Route::delete('/',                     [PermohonanDataController::class, 'bulkDestroy']) ->name('bulk-destroy');
        });

        Route::prefix('saran')->name('saran.')->group(function () {
            Route::get('/', [SuggestionController::class, 'index'])->name('index');
            Route::delete('/{suggestion}', [SuggestionController::class, 'destroy'])->name('destroy');
            Route::delete('/', [SuggestionController::class, 'bulkDestroy'])->name('bulk-destroy');
        });

        // ── Pengaturan: Akun Admin & Token API ─────────────────────────────
        Route::resource('users', UserController::class)->except(['show']);

        Route::prefix('tokens')->name('tokens.')->group(function () {
            Route::get('/', [ApiTokenController::class, 'index'])->name('index');
            Route::post('/', [ApiTokenController::class, 'store'])->name('store');
            Route::delete('/{token}', [ApiTokenController::class, 'destroy'])->name('destroy');
        });
    });

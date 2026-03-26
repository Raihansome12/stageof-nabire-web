<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/publikasi', [HomeController::class, 'publikasi'])->name('publikasi');
Route::get('/gempa-bumi', [HomeController::class, 'gempaBumi'])->name('gempa-bumi');
Route::get('/informasi-publik', [HomeController::class, 'informasiPublik'])->name('informasi-publik');
Route::get('/layanan-masyarakat', [HomeController::class, 'layananMasyarakat'])->name('layanan-masyarakat');

// Informasi Geofisika (TTM + Petir)
Route::get('/informasi-geofisika', [HomeController::class, 'informasiGeofisika'])
    ->name('informasi-geofisika');
 
// API: autocomplete lokasi TTM
Route::get('/api/ttm/locations', [HomeController::class, 'ttmLocations'])
    ->name('api.ttm.locations');

 // API: petir
Route::get('/api/petir/data', [HomeController::class, 'petirData'])->name('petir.data');
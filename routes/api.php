<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EarthquakeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Requires a token issued with the 'earthquakes:write' ability (or '*') — see
// Admin\ApiTokenController where abilities are set. Without this middleware
// ANY valid token could hit this route regardless of its issued abilities.
Route::middleware(['auth:sanctum', 'ability:earthquakes:write'])->post('/earthquakes', [EarthquakeController::class, 'store']);


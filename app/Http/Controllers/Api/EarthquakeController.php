<?php

namespace App\Http\Controllers\Api;

use App\Models\Earthquake;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EarthquakeController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate incoming structure including BMKG specific fields
        $request->validate([
            'earthquakes' => 'required|array',
            'earthquakes.*.magnitude' => 'required|numeric',
            'earthquakes.*.depth_km' => 'required|numeric',
            'earthquakes.*.latitude' => 'required|numeric',
            'earthquakes.*.longitude' => 'required|numeric',
            'earthquakes.*.location_description' => 'required|string',
            'earthquakes.*.occurred_at' => 'required|date_format:Y-m-d H:i:s',
            // Allow these fields to be empty or null since FDSNWS might not have them
            'earthquakes.*.felt_intensity' => 'nullable|string',
            'earthquakes.*.potensi' => 'nullable|string',
            'earthquakes.*.shakemap_image' => 'nullable|string',
        ]);

        $inserted = 0;
        $updated = 0;

        // Tolerances for matching identical earthquakes from different sources
        $timeToleranceMinutes = 5; 
        $spatialToleranceDegrees = 0.5; // Roughly 55km margin of error

        // 2. Process Records safely
        foreach ($request->earthquakes as $eq) {
            
            $occurredAt = Carbon::parse($eq['occurred_at']);
            
            // Search for an existing earthquake within our time and space window
            $existingEq = Earthquake::whereBetween('occurred_at', [
                    $occurredAt->copy()->subMinutes($timeToleranceMinutes),
                    $occurredAt->copy()->addMinutes($timeToleranceMinutes)
                ])
                ->whereBetween('latitude', [
                    $eq['latitude'] - $spatialToleranceDegrees, 
                    $eq['latitude'] + $spatialToleranceDegrees
                ])
                ->whereBetween('longitude', [
                    $eq['longitude'] - $spatialToleranceDegrees, 
                    $eq['longitude'] + $spatialToleranceDegrees
                ])
                ->first();

            if ($existingEq) {
                // Match found! Update it. 
                // We use the null coalescing operator (??) so that if the new payload 
                // doesn't have a shakemap/intensity, we don't accidentally erase the old one.
                $existingEq->update([
                    'magnitude' => $eq['magnitude'],
                    'depth_km' => $eq['depth_km'],
                    'location_description' => $eq['location_description'],
                    'felt_intensity' => $eq['felt_intensity'] ?? $existingEq->felt_intensity,
                    'potensi' => $eq['potensi'] ?? $existingEq->potensi,
                    'shakemap_image' => $eq['shakemap_image'] ?? $existingEq->shakemap_image,
                ]);
                $updated++;
            } else {
                // No match found, insert as a new record
                Earthquake::create([
                    'latitude' => $eq['latitude'],
                    'longitude' => $eq['longitude'],
                    'occurred_at' => $eq['occurred_at'],
                    'magnitude' => $eq['magnitude'],
                    'depth_km' => $eq['depth_km'],
                    'location_description' => $eq['location_description'],
                    // Set default fallbacks if the fields are null
                    'felt_intensity' => $eq['felt_intensity'] ?? '-',
                    'potensi' => $eq['potensi'] ?? 'Tidak berpotensi tsunami',
                    'shakemap_image' => $eq['shakemap_image'] ?? null,
                ]);
                $inserted++;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => "Successfully processed data: $inserted new records inserted, $updated records updated."
        ], 201);
    }
}
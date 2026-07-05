<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarthquakeController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate incoming structure
        $request->validate([
            'earthquakes' => 'required|array',
            'earthquakes.*.magnitude' => 'required|numeric',
            'earthquakes.*.depth_km' => 'required|numeric',
            'earthquakes.*.latitude' => 'required|numeric',
            'earthquakes.*.longitude' => 'required|numeric',
            'earthquakes.*.location_description' => 'required|string',
            'earthquakes.*.occurred_at' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $inserted = 0;

        // 2. Insert or Update Records safely
        foreach ($request->earthquakes as $eq) {
            DB::table('earthquakes')->updateOrCreate(
                [
                    'latitude' => $eq['latitude'],
                    'longitude' => $eq['longitude'],
                    'occurred_at' => $eq['occurred_at']
                ],
                [
                    'magnitude' => $eq['magnitude'],
                    'depth_km' => $eq['depth_km'],
                    'location_description' => $eq['location_description'],
                    'felt_intensity' => $eq['felt_intensity'] ?? '-',
                    'potensi' => $eq['potensi'] ?? 'Tidak berpotensi tsunami',
                ]
            );
            $inserted++;
        }

        return response()->json([
            'status' => 'success',
            'message' => "Successfully processed $inserted records."
        ], 201);
    }
}
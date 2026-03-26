<?php

namespace App\Jobs;

use App\Models\Earthquake;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchLatestEarthquake implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::timeout(15)->get('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml');

            if (! $response->successful()) {
                Log::warning('FetchLatestEarthquake: HTTP request failed', [
                    'status' => $response->status(),
                ]);
                return;
            }

            // Suppress libxml errors and parse XML
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($response->body());

            if ($xml === false) {
                Log::warning('FetchLatestEarthquake: Failed to parse XML', [
                    'errors' => libxml_get_errors(),
                ]);
                libxml_clear_errors();
                return;
            }

            $gempa = $xml->gempa;

            // Parse occurred_at from BMKG's DateTime field (ISO 8601)
            // e.g. "2024-03-22T07:47:06+07:00"
            $occurredAt = Carbon::parse((string) $gempa->DateTime)->utc();

            // Parse coordinates: BMKG gives "longitude,latitude" in point/coordinates
            // Also available separately as Lintang (lat) and Bujur (lon)
            $latitude  = $this->parseCoordinate((string) $gempa->Lintang);
            $longitude = $this->parseCoordinate((string) $gempa->Bujur);

            // Parse depth: "10 km" → 10
            $depthKm = (int) filter_var((string) $gempa->Kedalaman, FILTER_SANITIZE_NUMBER_INT);

            // Shakemap path from BMKG, e.g. "20240322074706.mmi.jpg"
            // BMKG serves it at https://static.bmkg.go.id/{Shakemap}
            $shakemapUrl = trim((string) $gempa->Shakemap) !== ''
                ? 'https://static.bmkg.go.id/' . trim((string) $gempa->Shakemap)
                : null;

            // Use updateOrCreate keyed on occurred_at so re-runs are idempotent
            Earthquake::updateOrCreate(
                ['occurred_at' => $occurredAt],
                [
                    'magnitude'            => (float) $gempa->Magnitude,
                    'depth_km'             => $depthKm,
                    'latitude'             => $latitude,
                    'longitude'            => $longitude,
                    'location_description' => (string) $gempa->Wilayah,
                    'felt_intensity'       => trim((string) $gempa->Dirasakan) ?: null,
                    'potensi'              => trim((string) $gempa->Potensi) ?: null,
                    'shakemap_image'       => $shakemapUrl,
                ]
            );

            Log::info('FetchLatestEarthquake: upserted earthquake', [
                'occurred_at' => $occurredAt->toDateTimeString(),
                'magnitude'   => (string) $gempa->Magnitude,
            ]);

        } catch (\Throwable $e) {
            Log::error('FetchLatestEarthquake: exception', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Convert BMKG coordinate strings to signed float.
     * Examples: "2.50 LS" → -2.50 | "140.25 BT" → 140.25
     */
    private function parseCoordinate(string $value): float
    {
        $value   = trim($value);
        $numeric = (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        // Southern latitude (LS) and western longitude (BB) are negative
        if (str_contains(strtoupper($value), 'LS') || str_contains(strtoupper($value), 'BB')) {
            $numeric = -abs($numeric);
        }

        return $numeric;
    }
}
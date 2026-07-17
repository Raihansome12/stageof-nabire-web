@extends('layouts.app')
@section('title', 'Gempa M' . number_format($earthquake->magnitude, 1) . ' — ' . $earthquake->location_description)

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

{{-- Sub-nav --}}
<div class="border-b border-blue-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4 h-14">
        <a href="{{ route('informasi-geofisika', ['tab' => 'gempa']) }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-bmkg-blue transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke daftar gempa
        </a>
    </div>
</div>

{{-- Content --}}
<section class="py-8 lg:py-12 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ══════════════ Top: Map + Info card ══════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Map --}}
            <div class="relative z-0 rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                <div id="eq-detail-map" class="w-full h-72 lg:h-full min-h-72"></div>
            </div>

            {{-- Info card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 lg:p-7 flex flex-col">

                <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                    <p class="text-sm text-gray-400">
                        {{ $earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('d M Y') }}
                        &bull;
                        {{ $earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('H.i.s') }} WIT
                    </p>

                    @if($earthquake->potensi)
                        @php
                            $isTsunami = str_contains(strtolower($earthquake->potensi), 'tsunami')
                                      && ! str_contains(strtolower($earthquake->potensi), 'tidak');
                        @endphp
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold
                            {{ $isTsunami ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $earthquake->potensi }}
                        </span>
                    @endif
                </div>

                <h1 class="font-heading font-bold text-xl lg:text-2xl text-bmkg-black mb-5">
                    {{ $earthquake->location_description }}
                </h1>

                <dl class="divide-y divide-gray-100 border-y border-gray-100">
                    <div class="flex items-center justify-between py-3">
                        <dt class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h4l2-5 4 10 2-5h6"/></svg>
                            Magnitudo
                        </dt>
                        <dd class="text-sm font-bold text-gray-800">{{ number_format($earthquake->magnitude, 1) }}</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg>
                            Kedalaman
                        </dt>
                        <dd class="text-sm font-bold text-gray-800">{{ $earthquake->depth_km }} km</dd>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <dt class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7z"/><circle cx="12" cy="9" r="2.5" fill="white"/></svg>
                            Koordinat
                        </dt>
                        <dd class="text-sm font-bold text-gray-800">
                            {{ number_format(abs($earthquake->latitude), 2) }}° {{ $earthquake->latitude < 0 ? 'LS' : 'LU' }}
                            &ndash;
                            {{ number_format(abs($earthquake->longitude), 2) }}° {{ $earthquake->longitude >= 0 ? 'BT' : 'BB' }}
                        </dd>
                    </div>
                    @if($earthquake->felt_intensity)
                        <div class="flex items-center justify-between py-3 gap-4">
                            <dt class="flex items-center gap-2 text-sm text-gray-500 shrink-0">
                                <svg class="w-4 h-4 text-bmkg-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M6 10.5V6a6 6 0 1112 0v4.5"/></svg>
                                Dirasakan
                            </dt>
                            <dd class="text-sm font-semibold text-gray-700 text-right">{{ $earthquake->felt_intensity }}</dd>
                        </div>
                    @endif
                </dl>

                {{-- Saran BMKG --}}
                <div class="mt-5 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3.5">
                    <p class="text-xs font-semibold text-blue-700 mb-1">Saran BMKG</p>
                    <p class="text-sm text-blue-800">
                        Hati-hati terhadap gempabumi susulan yang mungkin terjadi. Selalu pastikan informasi resmi dari kanal BMKG.
                    </p>
                </div>

                <p class="text-xs text-gray-400 mt-4">
                    &mdash; Waktu rilis: {{ $earthquake->updated_at->setTimezone('Asia/Jayapura')->format('d M Y') }}
                    &bull; {{ $earthquake->updated_at->setTimezone('Asia/Jayapura')->format('H.i.s') }} WIT
                </p>
            </div>
        </div>

        {{-- ══════════════ Siaran Pers ══════════════ --}}
        <div class="mt-10 lg:mt-14">
            <h2 class="font-heading font-bold text-2xl text-bmkg-black mb-5">Siaran Pers</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Narrative --}}
                <div class="lg:col-span-2">
                    @if($earthquake->description)
                        <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $earthquake->description }}</div>
                    @else
                        <p class="text-gray-400 italic">Belum ada siaran pers untuk kejadian gempa bumi ini.</p>
                    @endif
                </div>

                {{-- ShakeMap --}}
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-2">ShakeMap</p>
                    @if($hasShakemap)
                        <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                            <img src="{{ $earthquake->shakemap_image }}"
                                 alt="ShakeMap Gempa {{ $earthquake->location_description }}"
                                 class="w-full object-cover"
                                 loading="lazy"/>
                        </div>
                    @else
                        <div class="w-full h-56 bg-gray-100 rounded-xl border border-gray-200 flex items-center justify-center text-gray-400 text-sm">
                            <div class="text-center">
                                <div class="text-3xl mb-2">🗺️</div>
                                <div>Tidak ada ShakeMap</div>
                                <div class="text-xs text-gray-300 mt-1">untuk kejadian ini</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════ Related earthquakes ══════════════ --}}
        @if($recentEarthquakes->isNotEmpty())
            <div class="mt-12 lg:mt-16">
                <h2 class="font-heading font-bold text-xl text-bmkg-blue mb-5">Gempa Bumi Lainnya</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($recentEarthquakes as $re)
                        <a href="{{ route('earthquake.show', $re) }}"
                           class="info-card bg-bmkg-lightblue rounded-2xl p-4 hover:shadow-lg transition-shadow">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="shrink-0 w-12 h-12 rounded-lg flex flex-col items-center justify-center {{ $re->magnitude >= 5 ? 'mag-high' : ($re->magnitude >= 4 ? 'mag-mid' : 'mag-low') }}">
                                    <span class="text-base font-bold leading-none">{{ number_format($re->magnitude, 1) }}</span>
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ $re->occurred_at->setTimezone('Asia/Jayapura')->format('d M Y') }}
                                </p>
                            </div>
                            <p class="text-sm font-semibold text-gray-800 line-clamp-2">{{ $re->location_description }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    (function () {
        const eq = {
            lat: {{ (float) $earthquake->latitude }},
            lng: {{ (float) $earthquake->longitude }},
            mag: {{ (float) $earthquake->magnitude }},
            loc: @json($earthquake->location_description),
            depth: {{ (float) $earthquake->depth_km }},
            time: @json($earthquake->occurred_at->setTimezone('Asia/Jayapura')->format('d M Y H:i')),
            mmi: '{{ $earthquake->felt_intensity ?? "" }}'
        };

        const map = L.map('eq-detail-map', { zoomControl: true });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);

        function markerColor(mag) {
            return mag >= 5 ? '#ef4444' : (mag >= 4 ? '#f97316' : '#22c55e');
        }

        const c = markerColor(eq.mag);

        const html = `
            <div class="quake-epicenter" style="--eq-color: ${c}; --eq-color-soft: ${c}33;">
                <div class="eq-uncertainty"></div>
                <div class="eq-ring eq-ring-1"></div>
                <div class="eq-ring eq-ring-2"></div>
                <div class="eq-ring eq-ring-3"></div>
                <div class="eq-dot">${eq.mag}</div>
            </div>`;

        const icon = L.divIcon({
            html,
            className: '',
            iconSize: [70, 70],
            iconAnchor: [35, 35],
            popupAnchor: [0, -25]
        });

        L.marker([eq.lat, eq.lng], { icon }).addTo(map)
            .bindPopup(`
                <div class="eq-popup">
                    <div class="eq-popup-title">${eq.loc}</div>
                    <div class="eq-popup-time">${eq.time} WIT</div>
                    <div class="eq-popup-meta">
                        <span class="eq-popup-pill">M ${eq.mag} SR</span>
                        <span class="eq-popup-pill">⬇ ${eq.depth} km</span>
                        ${eq.mmi ? `<span class="eq-popup-pill">MMI ${eq.mmi}</span>` : ''}
                    </div>
                </div>
            `, { maxWidth: 260 }).openPopup();

        const center = L.latLng(eq.lat, eq.lng);
        const bounds = center.toBounds(300000);
        map.fitBounds(bounds);

        setTimeout(() => {
            map.invalidateSize();
            map.fitBounds(bounds);
        }, 150);
    })();
</script>
@endpush

{{-- ============================================================
     PANEL: Gempa Bumi Dirasakan
     Data: $feltEarthquake, $feltEqMapData, $otherFeltEarthquakes
     (from HomeController::informasiGeofisika)
     Shows only earthquakes that have ShakeMap data (shakemap_image not null),
     laid out the same way as pages/earthquake-show.blade.php.
     Leaflet JS/CSS are already loaded by the parent page / _tab-gempa panel.
     ============================================================ --}}
<div id="panel-gempa-dirasakan" class="panel-section hidden bg-white">
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Gempa Bumi Dirasakan</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Kejadian gempa bumi terkini yang telah dilengkapi data ShakeMap (peta guncangan)
                di wilayah Provinsi Papua Tengah.
            </p>
        </div>
    </div>

    <section class="py-8 lg:py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Admin quick-edit bar --}}
            <div class="flex justify-end pb-5">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.gempa.index') }}"
                           class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 shadow-sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Kelola Data Gempa
                        </a>
                    @endif
                @endauth
            </div>

            @if(! $feltEarthquake)
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center text-gray-400">
                    <div class="text-5xl mb-4">🗺️</div>
                    <p>Belum ada data gempa bumi dirasakan (ShakeMap) yang tersedia.</p>
                </div>
            @else

                {{-- ══════════════ Top: Map + Info card (mirrors earthquake-show) ══════════════ --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- Map --}}
                    <div class="relative z-0 rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                        <div id="eq-felt-map" class="w-full h-72 lg:h-full min-h-72"></div>
                    </div>

                    {{-- Info card --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 lg:p-7 flex flex-col">

                        <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                            <p class="text-sm text-gray-400">
                                {{ $feltEarthquake->occurred_at->copy()->setTimezone('Asia/Jayapura')->format('d M Y') }}
                                &bull;
                                {{ $feltEarthquake->occurred_at->copy()->setTimezone('Asia/Jayapura')->format('H.i.s') }} WIT
                            </p>

                            @if($feltEarthquake->potensi)
                                @php
                                    $isTsunami = str_contains(strtolower($feltEarthquake->potensi), 'tsunami')
                                              && ! str_contains(strtolower($feltEarthquake->potensi), 'tidak');
                                @endphp
                                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold
                                    {{ $isTsunami ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $feltEarthquake->potensi }}
                                </span>
                            @endif
                        </div>

                        <h1 class="font-heading font-bold text-xl lg:text-2xl text-bmkg-black mb-5">
                            {{ $feltEarthquake->location_description }}
                        </h1>

                        <dl class="divide-y divide-gray-100 border-y border-gray-100">
                            <div class="flex items-center justify-between py-3">
                                <dt class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h4l2-5 4 10 2-5h6"/></svg>
                                    Magnitudo
                                </dt>
                                <dd class="text-sm font-bold text-gray-800">{{ number_format($feltEarthquake->magnitude, 1) }}</dd>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <dt class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg>
                                    Kedalaman
                                </dt>
                                <dd class="text-sm font-bold text-gray-800">{{ $feltEarthquake->depth_km }} km</dd>
                            </div>
                            <div class="flex items-center justify-between py-3">
                                <dt class="flex items-center gap-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7z"/><circle cx="12" cy="9" r="2.5" fill="white"/></svg>
                                    Koordinat
                                </dt>
                                <dd class="text-sm font-bold text-gray-800">
                                    {{ number_format(abs($feltEarthquake->latitude), 2) }}° {{ $feltEarthquake->latitude < 0 ? 'LS' : 'LU' }}
                                    &ndash;
                                    {{ number_format(abs($feltEarthquake->longitude), 2) }}° {{ $feltEarthquake->longitude >= 0 ? 'BT' : 'BB' }}
                                </dd>
                            </div>
                            @if($feltEarthquake->felt_intensity)
                                <div class="flex items-center justify-between py-3 gap-4">
                                    <dt class="flex items-center gap-2 text-sm text-gray-500 shrink-0">
                                        <svg class="w-4 h-4 text-bmkg-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M6 10.5V6a6 6 0 1112 0v4.5"/></svg>
                                        Dirasakan
                                    </dt>
                                    <dd class="text-sm font-semibold text-gray-700 text-right">{{ $feltEarthquake->felt_intensity }}</dd>
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
                            &mdash; Waktu rilis: {{ $feltEarthquake->updated_at->setTimezone('Asia/Jayapura')->format('d M Y') }}
                            &bull; {{ $feltEarthquake->updated_at->setTimezone('Asia/Jayapura')->format('H.i.s') }} WIT
                        </p>
                    </div>
                </div>

                {{-- ══════════════ Siaran Pers + ShakeMap ══════════════ --}}
                <div class="mt-10 lg:mt-14">
                    <h2 class="font-heading font-bold text-2xl text-bmkg-black mb-5">Siaran Pers</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Narrative --}}
                        <div class="lg:col-span-2">
                            @if($feltEarthquake->description)
                                <div class="prose prose-sm sm:prose-base max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $feltEarthquake->description }}</div>
                            @else
                                <p class="text-gray-400 italic">Belum ada siaran pers untuk kejadian gempa bumi ini.</p>
                            @endif
                        </div>

                        {{-- ShakeMap (always present for this tab) --}}
                        <div>
                            <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-2">ShakeMap</p>
                            <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                <img src="{{ $feltEarthquake->shakemap_image }}"
                                     alt="ShakeMap Gempa {{ $feltEarthquake->location_description }}"
                                     class="w-full object-cover"
                                     loading="lazy"/>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════ Other felt earthquakes (with ShakeMap) ══════════════ --}}
                @if($otherFeltEarthquakes->isNotEmpty())
                    <div class="mt-12 lg:mt-16">
                        <h2 class="font-heading font-bold text-xl text-bmkg-blue mb-5">Gempa Dirasakan Lainnya</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                            @foreach($otherFeltEarthquakes as $re)
                                <a href="{{ route('earthquake.show', $re) }}"
                                   class="info-card bg-bmkg-lightblue rounded-2xl p-4 hover:shadow-lg transition-shadow">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="shrink-0 w-12 h-12 rounded-lg flex flex-col items-center justify-center {{ $re->magnitude >= 5 ? 'mag-high' : ($re->magnitude >= 4 ? 'mag-mid' : 'mag-low') }}">
                                            <span class="text-base font-bold leading-none">{{ number_format($re->magnitude, 1) }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ $re->occurred_at->copy()->setTimezone('Asia/Jayapura')->format('d M Y') }}
                                        </p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-800 line-clamp-2">{{ $re->location_description }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </section>
</div>{{-- end #panel-gempa-dirasakan --}}

@push('scripts')
<script>
/* ═══════════════════════════════════════════════════════════════
   Gempa Bumi Dirasakan — detail map (namespaced to avoid clashing
   with the Gempa Bumi Terkini tab's map/marker variables)
═══════════════════════════════════════════════════════════════ */
let feltMap = null;
let feltMapInitialized = false;
const feltEqData = @json($feltEqMapData);

function initFeltMap() {
    if (feltMapInitialized || !feltEqData.length) return;
    const eq = feltEqData[0];

    feltMap = L.map('eq-felt-map', { zoomControl: true });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18,
    }).addTo(feltMap);

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

    const icon = L.divIcon({ html, className: '', iconSize: [70, 70], iconAnchor: [35, 35], popupAnchor: [0, -25] });

    L.marker([eq.lat, eq.lng], { icon }).addTo(feltMap)
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
    feltMap.fitBounds(bounds);

    feltMapInitialized = true;

    setTimeout(() => {
        feltMap.invalidateSize();
        feltMap.fitBounds(bounds);
    }, 150);
}

function refreshFeltMap() {
    if (!feltMapInitialized) {
        initFeltMap();
    } else {
        setTimeout(() => {
            if (feltMap) feltMap.invalidateSize();
        }, 200);
    }
}
</script>
@endpush

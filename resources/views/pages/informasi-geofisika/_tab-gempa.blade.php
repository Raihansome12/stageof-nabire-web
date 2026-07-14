{{-- ============================================================
     PANEL: Gempa Bumi Terkini
     Data: $earthquakes, $eqMapData (from HomeController::informasiGeofisika)
     Leaflet CSS is loaded once in the parent informasi-geofisika.blade.php <head>.
     ============================================================ --}}
<div id="panel-gempa" class="panel-section hidden bg-white">
        <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Gempa Bumi Terkini</h1>
                <p class="text-gray-500 text-sm max-w-xl mx-auto">
                    Gempa bumi terkini adalah data waktu kejadian, magnitudo, kedalaman, beserta sebaran lokasi aktivitas seismik di wilayah Provinsi Papua Tengah.
                </p>
            </div>
        </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-15">
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
    


    {{-- Info box: link to national earthquake archive --}}
    <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3.5 mb-5 text-sm text-blue-800">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p>
            Untuk mengetahui pusat arsip data kegempaan dapat mengunjungi laman
            <a href="https://repogempa.bmkg.go.id/" target="_blank" rel="noopener" class="font-semibold underline hover:text-blue-900">repogempa.bmkg.go.id</a>.
        </p>
    </div>

    {{-- ── Filter bar ──────────────────────────────────── --}}
            <form method="GET" action="{{ route('informasi-geofisika') }}" id="filter-form">
                <input type="hidden" name="tab" value="gempa">
                <div class="filter-bar">

                    <div class="fg">
                        <label for="mag">Magnitudo</label>
                        <select name="mag" id="mag">
                            <option value=""    {{ request('mag') == ''    ? 'selected':'' }}>Semua</option>
                            <option value="gte5" {{ request('mag') == 'gte5' ? 'selected':'' }}>≥ 5.0 SR</option>
                            <option value="lt5"  {{ request('mag') == 'lt5'  ? 'selected':'' }}>&lt; 5.0 SR</option>
                        </select>
                    </div>

                    <div class="fg">
                        <label for="date_from">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from"
                            value="{{ request('date_from') }}"
                            max="{{ now()->toDateString() }}">
                    </div>

                    <div class="fg">
                        <label for="date_to">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to"
                            value="{{ request('date_to') }}"
                            max="{{ now()->toDateString() }}">
                        <span id="date-hint">Maksimal rentang 30 hari</span>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn-f btn-apply">Terapkan</button>
                        <a href="{{ route('informasi-geofisika', ['tab' => 'gempa']) }}" class="btn-f btn-reset">Reset</a>
                    </div>
                </div>
            </form>

            @if($earthquakes->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-12 text-center text-gray-400">
                <div class="text-5xl mb-4">🌍</div>
                <p>Tidak ada data gempa bumi untuk filter yang dipilih.</p>
            </div>
        @else

            {{-- ── Result chip ──────────────────────────────── --}}
            <div class="result-chip">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8"  x2="12"    y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ $earthquakes->count() }} gempa ditemukan
                @if(request('mag') == 'gte5') &nbsp;· M ≥ 5.0 @endif
                @if(request('mag') == 'lt5')  &nbsp;· M &lt; 5.0 @endif
                @if(request('date_from') && request('date_to'))
                    &nbsp;· {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                    – {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                @endif
            </div>

            {{-- ── Map ─────────────────────────────────────── --}}
            <div id="eq-map"></div>

            {{-- ── Earthquake list (scrollable, ~5 cards) ──── --}}
            <div id="eq-scroll-wrap">
            <div id="eq-list">
                @foreach($earthquakes as $index => $eq)
                    <div class="eq-card bg-bmkg-lightblue"
                         data-index="{{ $index }}"
                         data-lat="{{ $eq->latitude }}"
                         data-lng="{{ $eq->longitude }}">
                        <div class="flex flex-wrap gap-4 items-start">

                            {{-- Magnitude badge --}}
                            <div class="shrink-0 w-20 h-20 rounded-[0.75rem] flex flex-col items-center justify-center {{ $eq->magnitude >= 5 ? 'mag-high' : ($eq->magnitude >= 4 ? 'mag-mid' : 'mag-low') }}">
                                <span class="text-2xl font-bold leading-none">{{ $eq->magnitude }}</span>
                                <span class="text-[0.7rem] font-semibold mt-1">SR</span>
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-[0.82rem] text-gray-600 mb-1">
                                    {{ $eq->occurred_at->copy()->setTimezone('Asia/Jayapura')->format('d M Y') }} — {{ $eq->occurred_at->copy()->setTimezone('Asia/Jayapura')->format('H:i:s') }} WIT
                                </p>
                                <p class="font-semibold text-gray-800 mb-2">
                                    {{ $eq->location_description }}
                                </p>
                                <div class="flex flex-wrap gap-2 text-[0.82rem] text-gray-600">
                                    <span class="bg-white rounded-full px-3 py-1">
                                        📍 {{ number_format(abs($eq->latitude),3) }}° {{ $eq->latitude < 0 ? 'LS':'LU' }},
                                        {{ number_format(abs($eq->longitude),3) }}° BT
                                    </span>
                                    <span class="bg-white rounded-full px-3 py-1">
                                        ⬇ Kedalaman: {{ $eq->depth_km }} km
                                    </span>
                                </div>
                                @if($eq->felt_intensity)
                                    <p class="text-[0.82rem] text-emerald-600 mt-1">
                                        <span class="font-semibold">Dirasakan (MMI):</span>
                                        {{ $eq->felt_intensity }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            </div>{{-- /eq-scroll-wrap --}}

        @endif
    </div>
</div>{{-- end #panel-gempa --}}

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
/* ═══════════════════════════════════════════════════════════════
   State
═══════════════════════════════════════════════════════════════ */
let allEqData   = @json($eqMapData);

/* ═══════════════════════════════════════════════════════════════
   Map
═══════════════════════════════════════════════════════════════ */
const map = L.map('eq-map', { zoomControl:true });

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution:'© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom:18,
}).addTo(map);

const markerMap = {};

function markerColor(mag) {
    return mag >= 5 ? '#ef4444' : (mag >= 4 ? '#f97316' : '#22c55e');
}

function makeIcon(mag) {
    const c = markerColor(mag);
    const s = mag >= 5 ? 38 : (mag >= 4 ? 30 : 24);
    const html = `<svg xmlns="http://www.w3.org/2000/svg" width="${s}" height="${s}" viewBox="0 0 40 40">
        <circle cx="20" cy="20" r="18" fill="${c}" fill-opacity=".2" stroke="${c}" stroke-width="2"/>
        <circle cx="20" cy="20" r="9"  fill="${c}"/>
        <text x="20" y="24.5" text-anchor="middle" font-size="9.5" font-weight="700"
              fill="#fff" font-family="system-ui,sans-serif">${mag}</text>
    </svg>`;
    return L.divIcon({ html, className:'', iconSize:[s,s], iconAnchor:[s/2,s/2], popupAnchor:[0,-(s/2)] });
}

function addMarker(eq) {
    if (markerMap[eq.index]) return;
    const m = L.marker([eq.lat, eq.lng], { icon:makeIcon(eq.mag) })
        .bindPopup(`
            <div class="eq-popup">
                <div class="eq-popup-title">${eq.loc}</div>
                <div class="eq-popup-time">${eq.time} WIT</div>
                <div class="eq-popup-meta">
                    <span class="eq-popup-pill">M ${eq.mag} SR</span>
                    <span class="eq-popup-pill">⬇ ${eq.depth} km</span>
                    ${eq.mmi ? `<span class="eq-popup-pill">MMI ${eq.mmi}</span>` : ''}
                </div>
            </div>`, { maxWidth:290 })
        .addTo(map);
    m.on('popupopen', () => highlightCard(eq.index));
    markerMap[eq.index] = m;
}

function fitMap() {
    const all = Object.values(markerMap);
    if (!all.length) { map.setView([-3.37, 135.5], 7); return; }
    map.fitBounds(L.featureGroup(all).getBounds().pad(0.25));
}

allEqData.forEach(addMarker);
fitMap();

/* ═══════════════════════════════════════════════════════════════
   Card ↔ Map
═══════════════════════════════════════════════════════════════ */
function highlightCard(idx) {
    document.querySelectorAll('.eq-card').forEach(c => c.classList.remove('highlighted'));
    const card = document.querySelector(`.eq-card[data-index="${idx}"]`);
    if (card) {
        card.classList.add('highlighted');
        // scroll within the list container, not the page
        const wrap = document.getElementById('eq-scroll-wrap');
        const cardTop  = card.offsetTop - wrap.offsetTop;
        const cardBot  = cardTop + card.offsetHeight;
        const wrapTop  = wrap.scrollTop;
        const wrapBot  = wrap.scrollTop + wrap.clientHeight;
        if (cardTop < wrapTop || cardBot > wrapBot) {
            wrap.scrollTo({ top: cardTop - 16, behavior:'smooth' });
        }
    }
}

function bindCard(card) {
    card.addEventListener('click', () => {
        const idx = parseInt(card.dataset.index);
        const m   = markerMap[idx];
        if (!m) return;
        // scroll the PAGE to the map
        document.getElementById('eq-map').scrollIntoView({ behavior:'smooth', block:'center' });
        map.flyTo(m.getLatLng(), 9, { animate:true, duration:.8 });
        setTimeout(() => m.openPopup(), 850);
        document.querySelectorAll('.eq-card').forEach(c => c.classList.remove('highlighted'));
        card.classList.add('highlighted');
    });
}

document.querySelectorAll('.eq-card').forEach(bindCard);



/* ═══════════════════════════════════════════════════════════════
   Date range validation
═══════════════════════════════════════════════════════════════ */
const fromInput  = document.getElementById('date_from');
const toInput    = document.getElementById('date_to');
const hint       = document.getElementById('date-hint');
const filterForm = document.getElementById('filter-form');

function validateDates() {
    if (!fromInput.value || !toInput.value) { hint.style.display='none'; return true; }
    const diff = (new Date(toInput.value) - new Date(fromInput.value)) / 86400000;
    if (diff < 0) {
        hint.textContent = 'Tanggal akhir harus setelah tanggal awal';
        hint.style.display = 'block'; return false;
    }
    if (diff > 30) {
        hint.textContent = 'Maksimal rentang 30 hari';
        hint.style.display = 'block'; return false;
    }
    hint.style.display = 'none'; return true;
}

fromInput.addEventListener('change', () => {
    if (fromInput.value) {
        const cap = new Date(fromInput.value);
        cap.setDate(cap.getDate() + 30);
        toInput.max = cap.toISOString().split('T')[0];
        if (toInput.value > toInput.max) toInput.value = toInput.max;
    }
    validateDates();
});
toInput.addEventListener('change', validateDates);
filterForm.addEventListener('submit', e => { if (!validateDates()) e.preventDefault(); });
</script>
@endpush

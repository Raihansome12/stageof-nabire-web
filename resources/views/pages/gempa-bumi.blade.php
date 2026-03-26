@extends('layouts.app')
@section('title', 'Gempa Bumi - Stasiun Geofisika Kelas III Nabire')

@section('content')

{{-- Leaflet CSS: loaded inline here so it's never blocked by @push stack order --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
/* ── Variables ───────────────────────────────────────────────── */
:root {
    --eq-radius : 1rem;
    --eq-border : #e5e7eb;
    --eq-shadow : 0 1px 4px rgba(0,0,0,.07);
    --eq-blue   : #1d4ed8;
    --eq-blue-lt: #eff6ff;
}

/* ── Filter bar ──────────────────────────────────────────────── */
.filter-bar {
    background   : #fff;
    border       : 1px solid var(--eq-border);
    border-radius: var(--eq-radius);
    padding      : 1rem 1.25rem;
    display      : flex;
    flex-wrap    : wrap;
    gap          : .75rem;
    align-items  : flex-end;
    margin-bottom: 1.25rem;
    box-shadow   : var(--eq-shadow);
}
.fg { display:flex; flex-direction:column; gap:.25rem; flex:1 1 150px; }
.fg label {
    font-size:     .7rem;
    font-weight:   700;
    color:         #9ca3af;
    text-transform:uppercase;
    letter-spacing:.05em;
}
.fg select,
.fg input[type="date"] {
    border       : 1px solid var(--eq-border);
    border-radius: .5rem;
    padding      : .45rem .7rem;
    font-size    : .875rem;
    color        : #111827;
    background   : #f9fafb;
    outline      : none;
    transition   : border-color .15s, background .15s;
    width        : 100%;
}
.fg select:focus,
.fg input[type="date"]:focus { border-color:var(--eq-blue); background:#fff; }

.filter-actions { display:flex; gap:.5rem; align-self:flex-end; }
.btn-f {
    padding      : .48rem 1.1rem;
    border-radius: .5rem;
    font-size    : .875rem;
    font-weight  : 600;
    cursor       : pointer;
    border       : none;
    transition   : background .15s, transform .1s;
    white-space  : nowrap;
}
.btn-f:active   { transform:scale(.97); }
.btn-apply      { background:var(--eq-blue); color:#fff; }
.btn-apply:hover{ background:#1e40af; }
.btn-reset {
    background : #f3f4f6;
    color      : #374151;
    border     : 1px solid var(--eq-border);
    text-decoration: none;
    display    : inline-flex;
    align-items: center;
}
.btn-reset:hover { background:#e5e7eb; }

#date-hint {
    font-size : .7rem;
    color     : #ef4444;
    margin-top: .2rem;
    display   : none;
}

/* ── Result chip ─────────────────────────────────────────────── */
.result-chip {
    display      : inline-flex;
    align-items  : center;
    gap          : .35rem;
    background   : var(--eq-blue-lt);
    color        : var(--eq-blue);
    font-size    : .78rem;
    font-weight  : 600;
    padding      : .3rem .75rem;
    border-radius: 999px;
    margin-bottom: 1rem;
}

/* ── Map ─────────────────────────────────────────────────────── */
#eq-map {
    width        : 100%;      /* same as list below */
    height       : 380px;
    border-radius: var(--eq-radius);
    border       : 1px solid var(--eq-border);
    margin-bottom: 1.25rem;
    box-shadow   : var(--eq-shadow);
    position     : relative;  /* required by Leaflet */
    z-index      : 0;
}

/* ── Earthquake cards ────────────────────────────────────────── */
.mag-high { background:#fee2e2; color:#b91c1c; }
.mag-mid  { background:#ffedd5; color:#c2410c; }
.mag-low  { background:#dcfce7; color:#15803d; }

.eq-card {
    background   : #fff;
    border-radius: var(--eq-radius);
    box-shadow   : var(--eq-shadow);
    padding      : 1.25rem 1.5rem;
    cursor       : pointer;
    transition   : box-shadow .2s, transform .2s;
    border       : 1px solid transparent;
}
.eq-card:hover {
    box-shadow: 0 4px 18px rgba(0,0,0,.10);
    transform : translateY(-1px);
}
.eq-card.highlighted {
    border-color: var(--eq-blue);
    box-shadow  : 0 0 0 3px rgba(29,78,216,.13);
}

/* ── Scrollable list wrapper (~5 cards visible) ──────────────── */
#eq-scroll-wrap {
    height         : 680px;
    overflow-y     : auto;
    border-radius  : var(--eq-radius);
    box-shadow     : inset 0 -28px 18px -18px rgba(0,0,0,.07),
                     inset 0  12px 10px -10px rgba(0,0,0,.03);
    scroll-behavior: smooth;
    scrollbar-width: thin;
    scrollbar-color: #d1d5db transparent;
}
#eq-scroll-wrap::-webkit-scrollbar       { width:5px; }
#eq-scroll-wrap::-webkit-scrollbar-track { background:transparent; }
#eq-scroll-wrap::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:99px; }

/* ── List & sentinel ─────────────────────────────────────────── */
#eq-list { display:flex; flex-direction:column; gap:1rem; padding:.25rem .15rem; }

#eq-sentinel {
    height         : 56px;
    display        : flex;
    align-items    : center;
    justify-content: center;
    margin-top     : .5rem;
    color          : #9ca3af;
    font-size      : .82rem;
    gap            : .5rem;
}

</style>

<section class="">
    <div class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex gap-1 overflow-x-auto" id="geo-tabs">
                <a
                    href="{{ route('home') }}"
                    id="tab-beranda"
                    class="flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                >
                    Beranda
                </a>
                <button
                    onclick="switchTab('gempa')"
                    id="tab-gempa"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-bmkg-blue text-bmkg-blue transition-all duration-200 whitespace-nowrap"
                    >
                    Gempa Bumi Terkini
                </button>
            </nav>
        </div>
    </div>

    <div id="panel-gempa" class="panel-section bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Gempa Bumi Terkini</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia voluptatibus, explicabo vero quis inventore expedita, officiis aliquam sint iste aut doloremque? Voluptate exercitationem totam cumque officia quasi dignissimos distinctio eum?
            </p>
        </div>
    </div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-15">
    {{-- ── Filter bar ──────────────────────────────────── --}}
            <form method="GET" action="{{ route('gempa-bumi') }}" id="filter-form">
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
                        <a href="{{ route('gempa-bumi') }}" class="btn-f btn-reset">Reset</a>
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
                    <div class="eq-card"
                         data-index="{{ $index }}"
                         data-lat="{{ $eq->latitude }}"
                         data-lng="{{ $eq->longitude }}">
                        <div style="display:flex;flex-wrap:wrap;gap:1rem;align-items:flex-start">

                            {{-- Magnitude badge --}}
                            <div class="shrink-0 {{ $eq->magnitude >= 5 ? 'mag-high' : ($eq->magnitude >= 4 ? 'mag-mid' : 'mag-low') }}"
                                 style="width:5rem;height:5rem;border-radius:.75rem;display:flex;flex-direction:column;align-items:center;justify-content:center">
                                <span style="font-size:1.5rem;font-weight:700;line-height:1">{{ $eq->magnitude }}</span>
                                <span style="font-size:.7rem;font-weight:600;margin-top:.1rem">SR</span>
                            </div>

                            {{-- Details --}}
                            <div style="flex:1;min-width:0">
                                <p style="font-size:.82rem;color:#9ca3af;margin-bottom:.25rem">
                                    {{ $eq->occurred_at->format('d M Y') }} — {{ $eq->occurred_at->format('H:i:s') }} UTC
                                </p>
                                <p style="font-weight:600;color:#1f2937;margin-bottom:.5rem">
                                    {{ $eq->location_description }}
                                </p>
                                <div style="display:flex;flex-wrap:wrap;gap:.5rem;font-size:.82rem;color:#4b5563">
                                    <span style="background:#f3f4f6;border-radius:.5rem;padding:.2rem .65rem">
                                        📍 {{ number_format(abs($eq->latitude),3) }}° {{ $eq->latitude < 0 ? 'LS':'LU' }},
                                        {{ number_format(abs($eq->longitude),3) }}° BT
                                    </span>
                                    <span style="background:#f3f4f6;border-radius:.5rem;padding:.2rem .65rem">
                                        ⬇ Kedalaman: {{ $eq->depth_km }} km
                                    </span>
                                </div>
                                @if($eq->felt_intensity)
                                    <p style="font-size:.82rem;color:#6b7280;margin-top:.4rem">
                                        <span style="font-weight:600">Dirasakan (MMI):</span>
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
</section>

<script>
    // ── Tab switching (prepare for future sections) ─────────────────────────
    function switchTab(name) {
        document.querySelectorAll('.panel-section').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-bmkg-blue', 'text-bmkg-blue');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        const panel = document.getElementById('panel-' + name);
        if (panel) panel.classList.remove('hidden');

        const activeTab = document.getElementById('tab-' + name);
        if (activeTab) {
            activeTab.classList.add('border-bmkg-blue', 'text-bmkg-blue');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
        }

        // Keep the URL param in sync (optional; helps bookmarking future tabs)
        const url = new URL(window.location.href);
        url.searchParams.set('tab', name);
        window.history.replaceState({}, '', url.toString());
    }

    // Default active tab for this page: gempa
    (function () {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab') || 'gempa';
        switchTab(tab);
    })();
</script>

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
            <div style="min-width:210px;font-family:system-ui,sans-serif">
                <div style="font-weight:700;font-size:.9rem;margin-bottom:.3rem;line-height:1.35">${eq.loc}</div>
                <div style="font-size:.78rem;color:#6b7280;margin-bottom:.45rem">${eq.time} WIB</div>
                <div style="display:flex;gap:.4rem;flex-wrap:wrap;font-size:.78rem">
                    <span style="background:#f3f4f6;padding:.15rem .5rem;border-radius:.35rem">M ${eq.mag} SR</span>
                    <span style="background:#f3f4f6;padding:.15rem .5rem;border-radius:.35rem">⬇ ${eq.depth} km</span>
                    ${eq.mmi ? `<span style="background:#f3f4f6;padding:.15rem .5rem;border-radius:.35rem">MMI ${eq.mmi}</span>` : ''}
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
@endsection
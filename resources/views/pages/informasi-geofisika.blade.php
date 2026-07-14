@extends('layouts.app')
@section('title', 'Informasi Geofisika - Stasiun Geofisika Kelas III Nabire')

@section('content')

{{-- Leaflet CSS: needed by the "Gempa Bumi Terkini" tab's map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

{{-- Tab Navigation --}}
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
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
            >
                Gempa Bumi Terkini
            </button>
            <button
                onclick="switchTab('petir')"
                id="tab-petir"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
            >
                Peta Sambaran Petir
            </button>
            <button
                onclick="switchTab('ttm')"
                id="tab-ttm"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
            >
                Terbit-Terbenam Matahari
            </button>
            <button
                onclick="switchTab('hilal')"
                id="tab-hilal"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
            >
                Informasi Hilal
            </button>
        </nav>
    </div>
</div>

{{-- Each panel below is its own partial to keep this file manageable.
     See resources/views/pages/informasi-geofisika/_tab-*.blade.php --}}
@include('pages.informasi-geofisika._tab-ttm')
@include('pages.informasi-geofisika._tab-petir')
@include('pages.informasi-geofisika._tab-gempa')
@include('pages.informasi-geofisika._tab-hilal')

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ══════════════════════════════════════════════════════════════════════════════
// Tab switching
// ══════════════════════════════════════════════════════════════════════════════
function switchTab(name) {
    document.querySelectorAll('.panel-section').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-bmkg-blue', 'text-bmkg-blue');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById('panel-' + name).classList.remove('hidden');
    const activeTab = document.getElementById('tab-' + name);
    activeTab.classList.add('border-bmkg-blue', 'text-bmkg-blue');
    activeTab.classList.remove('border-transparent', 'text-gray-500');

    // Keep the URL param in sync (optional; helps bookmarking future tabs)
    const url = new URL(window.location.href);
        url.searchParams.set('tab', name);
        window.history.replaceState({}, '', url.toString());
}

(function () {
    const params = new URLSearchParams(window.location.search);
    switchTab(params.get('tab') || 'ttm');
})();

// ── TTM month selector ────────────────────────────────────────────────────
function selectMonth(num) {
    document.getElementById('ttm-month-hidden').value = num;
    document.querySelectorAll('.month-btn').forEach(btn => {
        btn.classList.remove('bg-bmkg-blue', 'text-white', 'border-bmkg-blue', 'shadow-sm');
        btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
    });
    const active = document.getElementById('month-btn-' + num);
    active.classList.add('bg-bmkg-blue', 'text-white', 'border-bmkg-blue', 'shadow-sm');
    active.classList.remove('bg-white', 'text-gray-700', 'border-gray-300');
    document.getElementById('ttm-form').submit();
}

// ══════════════════════════════════════════════════════════════════════════════
// Shared helpers
// ══════════════════════════════════════════════════════════════════════════════
const MN = {
    1:'Januari',2:'Februari',3:'Maret',4:'April',5:'Mei',6:'Juni',
    7:'Juli',8:'Agustus',9:'September',10:'Oktober',11:'November',12:'Desember'
};

function buildBarChart(canvasId, labels, values, color, titleText) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{ label: 'Total', data: values, backgroundColor: color, borderRadius: 5, borderSkipped: false }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: titleText, font: { size: 12, weight: '600', family: 'inherit' }, color: '#374151', padding: { bottom: 10 } }
            },
            scales: {
                x: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 }, color: '#6b7280', maxRotation: 45 } },
                y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 10 }, color: '#6b7280' }, beginAtZero: true }
            }
        }
    });
}

function apiFetch(params) {
    return fetch('/api/petir/data?' + new URLSearchParams(params).toString(), {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    }).then(r => r.json());
}

function setMapState(imgId, noImgId, updatedId, data) {
    const img = document.getElementById(imgId);
    const noImg = document.getElementById(noImgId);
    if (data.map_url) {
        img.src = data.map_url;
        img.classList.remove('hidden');
        noImg.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        noImg.classList.remove('hidden');
    }
    document.getElementById(updatedId).textContent = data.map_updated_at
        ? 'Updated: ' + data.map_updated_at
        : 'Peta belum diperbarui.';
}

// ══════════════════════════════════════════════════════════════════════════════
// SECTION A — DASARIAN (independent)
// ══════════════════════════════════════════════════════════════════════════════
const DAS_BLUE = '#1a6fad';
let dasActiveDas   = 1;
let dasChartSub    = null;
let dasChartDaily  = null;
let dasChartPanels = ['sub', 'daily'];
let dasChartIdx    = 0;

function setDas(d) {
    dasActiveDas = d;
    document.querySelectorAll('.das-btn').forEach(b => {
        b.classList.remove('bg-bmkg-blue', 'text-white', 'shadow-sm');
        b.classList.add('text-gray-600');
    });
    document.getElementById('das-btn-' + d).classList.add('bg-bmkg-blue', 'text-white', 'shadow-sm');
    document.getElementById('das-btn-' + d).classList.remove('text-gray-600');
    loadDasarianData();
}

function switchDasChart(name) {
    dasChartIdx = dasChartPanels.indexOf(name);
    dasChartPanels.forEach(p => {
        const on = p === name;
        document.getElementById('das-panel-' + p).classList.toggle('hidden', !on);
        const tab = document.getElementById('das-tab-' + p);
        const dot = document.getElementById('das-dot-' + p);
        if (on) {
            tab.classList.add('border-bmkg-blue','text-bmkg-blue'); tab.classList.remove('border-transparent','text-gray-400');
            dot.classList.add('bg-bmkg-blue'); dot.classList.remove('bg-gray-300');
        } else {
            tab.classList.remove('border-bmkg-blue','text-bmkg-blue'); tab.classList.add('border-transparent','text-gray-400');
            dot.classList.remove('bg-bmkg-blue'); dot.classList.add('bg-gray-300');
        }
    });
}
function nextDasChart() { dasChartIdx = (dasChartIdx+1) % dasChartPanels.length; switchDasChart(dasChartPanels[dasChartIdx]); }
function prevDasChart() { dasChartIdx = (dasChartIdx-1+dasChartPanels.length) % dasChartPanels.length; switchDasChart(dasChartPanels[dasChartIdx]); }

function loadDasarianData() {
    const month = parseInt(document.getElementById('das-month').value);
    const year  = parseInt(document.getElementById('das-year').value);
    const dasLabel = ['Dasarian I','Dasarian II','Dasarian III'][dasActiveDas-1];
    const label = MN[month] + ' ' + year + ' – ' + dasLabel;

    document.getElementById('das-period-badge').textContent = label;
    document.getElementById('das-loading').classList.remove('hidden');
    document.getElementById('das-empty').classList.add('hidden');
    document.getElementById('das-data').classList.add('hidden');

    apiFetch({ month, year, type: 'dasarian', dasarian: dasActiveDas })
        .then(data => {
            document.getElementById('das-loading').classList.add('hidden');
            if (!data || !data.period) { document.getElementById('das-empty').classList.remove('hidden'); return; }

            document.getElementById('das-data').classList.remove('hidden');
            document.getElementById('das-map-subtitle').textContent = label;
            setMapState('das-map-img','das-map-noimg','das-map-updated', data);

            if (dasChartSub)   { dasChartSub.destroy();   dasChartSub   = null; }
            if (dasChartDaily) { dasChartDaily.destroy(); dasChartDaily = null; }

            if (data.subdistrict_stats && data.subdistrict_stats.length) {
                document.getElementById('das-sub-nodata').classList.add('hidden');
                document.getElementById('das-chart-sub').classList.remove('hidden');
                dasChartSub = buildBarChart('das-chart-sub',
                    data.subdistrict_stats.map(s=>s.subdistrict),
                    data.subdistrict_stats.map(s=>s.total_strikes),
                    DAS_BLUE, 'Total Kejadian Petir – ' + label);
            } else {
                document.getElementById('das-sub-nodata').classList.remove('hidden');
                document.getElementById('das-chart-sub').classList.add('hidden');
            }

            if (data.daily_densities && data.daily_densities.length) {
                document.getElementById('das-daily-nodata').classList.add('hidden');
                document.getElementById('das-chart-daily').classList.remove('hidden');
                dasChartDaily = buildBarChart('das-chart-daily',
                    data.daily_densities.map(d=>d.date),
                    data.daily_densities.map(d=>d.total_density),
                    DAS_BLUE, 'Kerapatan Harian – ' + label);
            } else {
                document.getElementById('das-daily-nodata').classList.remove('hidden');
                document.getElementById('das-chart-daily').classList.add('hidden');
            }

            switchDasChart('sub');
        })
        .catch(() => {
            document.getElementById('das-loading').classList.add('hidden');
            document.getElementById('das-empty').classList.remove('hidden');
        });
}

// ══════════════════════════════════════════════════════════════════════════════
// SECTION B — BULANAN (independent)
// ══════════════════════════════════════════════════════════════════════════════
const BUL_TEAL = '#14b8a6';
let bulChartSub    = null;
let bulChartDaily  = null;
let bulChartPanels = ['sub', 'daily'];
let bulChartIdx    = 0;

function switchBulChart(name) {
    bulChartIdx = bulChartPanels.indexOf(name);
    bulChartPanels.forEach(p => {
        const on = p === name;
        document.getElementById('bul-panel-' + p).classList.toggle('hidden', !on);
        const tab = document.getElementById('bul-tab-' + p);
        const dot = document.getElementById('bul-dot-' + p);
        if (on) {
            tab.classList.add('border-teal-500','text-teal-600'); tab.classList.remove('border-transparent','text-gray-400');
            dot.classList.add('bg-teal-500'); dot.classList.remove('bg-gray-300');
        } else {
            tab.classList.remove('border-teal-500','text-teal-600'); tab.classList.add('border-transparent','text-gray-400');
            dot.classList.remove('bg-teal-500'); dot.classList.add('bg-gray-300');
        }
    });
}
function nextBulChart() { bulChartIdx = (bulChartIdx+1) % bulChartPanels.length; switchBulChart(bulChartPanels[bulChartIdx]); }
function prevBulChart() { bulChartIdx = (bulChartIdx-1+bulChartPanels.length) % bulChartPanels.length; switchBulChart(bulChartPanels[bulChartIdx]); }

function loadBulananData() {
    const month = parseInt(document.getElementById('bul-month').value);
    const year  = parseInt(document.getElementById('bul-year').value);
    const label = MN[month] + ' ' + year + ' – Bulanan';

    document.getElementById('bul-period-badge').textContent = label;
    document.getElementById('bul-loading').classList.remove('hidden');
    document.getElementById('bul-empty').classList.add('hidden');
    document.getElementById('bul-data').classList.add('hidden');

    apiFetch({ month, year, type: 'bulanan' })
        .then(data => {
            document.getElementById('bul-loading').classList.add('hidden');
            if (!data || !data.period) { document.getElementById('bul-empty').classList.remove('hidden'); return; }

            document.getElementById('bul-data').classList.remove('hidden');
            document.getElementById('bul-map-subtitle').textContent = label;
            setMapState('bul-map-img','bul-map-noimg','bul-map-updated', data);

            if (bulChartSub)   { bulChartSub.destroy();   bulChartSub   = null; }
            if (bulChartDaily) { bulChartDaily.destroy(); bulChartDaily = null; }

            if (data.subdistrict_stats && data.subdistrict_stats.length) {
                document.getElementById('bul-sub-nodata').classList.add('hidden');
                document.getElementById('bul-chart-sub').classList.remove('hidden');
                bulChartSub = buildBarChart('bul-chart-sub',
                    data.subdistrict_stats.map(s=>s.subdistrict),
                    data.subdistrict_stats.map(s=>s.total_strikes),
                    BUL_TEAL, 'Total Kejadian Petir – ' + label);
            } else {
                document.getElementById('bul-sub-nodata').classList.remove('hidden');
                document.getElementById('bul-chart-sub').classList.add('hidden');
            }

            if (data.daily_densities && data.daily_densities.length) {
                document.getElementById('bul-daily-nodata').classList.add('hidden');
                document.getElementById('bul-chart-daily').classList.remove('hidden');
                bulChartDaily = buildBarChart('bul-chart-daily',
                    data.daily_densities.map(d=>d.date),
                    data.daily_densities.map(d=>d.total_density),
                    BUL_TEAL, 'Kerapatan Harian – ' + label);
            } else {
                document.getElementById('bul-daily-nodata').classList.remove('hidden');
                document.getElementById('bul-chart-daily').classList.add('hidden');
            }

            switchBulChart('sub');
        })
        .catch(() => {
            document.getElementById('bul-loading').classList.add('hidden');
            document.getElementById('bul-empty').classList.remove('hidden');
        });
}

// ── Bootstrap ─────────────────────────────────────────────────────────────
let petirLoaded = false;

document.getElementById('tab-petir').addEventListener('click', function () {
    if (!petirLoaded) {
        petirLoaded = true;
        loadDasarianData();
        loadBulananData();
    }
});

(function () {
    const params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'petir') {
        petirLoaded = true;
        loadDasarianData();
        loadBulananData();
    }
})();
</script>
@endpush

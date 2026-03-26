@extends('layouts.app')
@section('title', 'Informasi Geofisika - Stasiun Geofisika Kelas III Nabire')

@section('content')

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
                onclick="switchTab('ttm')"
                id="tab-ttm"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
            >
                Terbit-Terbenam Matahari
            </button>
            <button
                onclick="switchTab('petir')"
                id="tab-petir"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
            >
                Peta Sambaran Petir
            </button>
        </nav>
    </div>
</div>

{{-- ============================================================
     PANEL: Terbit-Terbenam Matahari (TTM)
     ============================================================ --}}
<div id="panel-ttm" class="panel-section">

    <div class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Terbit-Terbenam Matahari</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Informasi terbit-terbenam Matahari adalah data waktu matahari terbit, transit, dan terbenam
                beserta azimut untuk setiap wilayah di Indonesia.
            </p>
        </div>
    </div>

    <section class="py-8 lg:py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden p-3">
                <div class="px-6 pt-5 pb-6">
                    <form method="GET" action="{{ route('informasi-geofisika') }}" id="ttm-form">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <div class="flex items-center gap-3 flex-1">
                                <span class="font-semibold text-gray-800 text-lg whitespace-nowrap">
                                    Waktu TTM di Wilayah:
                                </span>
                                <div class="relative flex-1 max-w-xs">
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <circle cx="11" cy="11" r="7" stroke-width="2"></circle>
                                            <path d="M20 20L17 17" stroke-width="2"></path>
                                        </svg>
                                    </div>
                                    <select
                                        name="location"
                                        id="ttm-location-select"
                                        onchange="document.getElementById('ttm-form').submit()"
                                        class="w-full bg-gray-100 rounded-lg px-4 py-2 pr-10 text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-bmkg-blue/30 border border-gray-200 hover:bg-gray-50 transition cursor-pointer appearance-none"
                                    >
                                        @foreach($ttmRegions as $region)
                                            <option value="{{ $region }}" @selected($region === $location)>{{ $region }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="month" id="ttm-month-hidden" value="{{ request('month', date('n')) }}">

                        <div class="mt-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 overflow-x-auto flex-1">
                                @php
                                    $months = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                        5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agt',
                                        9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
                                    ];
                                    $selectedMonth = (int) request('month', date('n'));
                                @endphp
                                @foreach($months as $num => $label)
                                    <button
                                        type="button"
                                        onclick="selectMonth({{ $num }})"
                                        id="month-btn-{{ $num }}"
                                        class="month-btn px-4 py-3 rounded-2xl border text-sm font-medium transition-all duration-150 whitespace-nowrap
                                            {{ $num === $selectedMonth
                                                ? 'bg-bmkg-blue text-white border-bmkg-blue shadow-sm'
                                                : 'bg-white text-gray-700 border-gray-300 hover:border-bmkg-blue hover:text-bmkg-blue' }}"
                                    >{{ $label }}</button>
                                @endforeach
                            </div>
                            <div class="relative flex-shrink-0">
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M6 9l6 6 6-6" stroke-width="2"/>
                                    </svg>
                                </div>
                                <select name="year" id="ttm-year" onchange="document.getElementById('ttm-form').submit()"
                                    class="bg-gray-100 rounded-lg px-4 py-2 pr-10 text-sm text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-bmkg-blue/30 border border-gray-200 hover:bg-gray-50 transition cursor-pointer appearance-none">
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" @selected($y == ($year ?? date('Y')))>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto px-4">
                    @if(isset($sunrisesTable) && $sunrisesTable->count())
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 rounded-l-xl">Tanggal</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Waktu<br>Fajar</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Waktu<br>Terbit</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Azimut<br>Terbit (°)</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Waktu<br>Transit</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Tinggi<br>Transit</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Waktu<br>Terbenam</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap">Azimut<br>Terbenam (°)</th>
                                    <th class="px-5 py-3 text-left font-semibold text-gray-700 whitespace-nowrap rounded-r-xl">Waktu<br>Senja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sunrisesTable as $row)
                                    <tr class="bg-white border-b border-gray-100">
                                        <td class="px-5 py-3 text-gray-800 font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                                        <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $row->dawn_time    ? \Carbon\Carbon::parse($row->dawn_time)->format('H:i')    . ' WIT' : '-' }}</td>
                                        <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $row->sunrise_time ? \Carbon\Carbon::parse($row->sunrise_time)->format('H:i') . ' WIT' : '-' }}</td>
                                        <td class="px-5 py-3 text-gray-700">{{ $row->azimuth_sunrise ?? '-' }}</td>
                                        <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $row->transit_time ? \Carbon\Carbon::parse($row->transit_time)->format('H:i') . ' WIT' : '-' }}</td>
                                        <td class="px-5 py-3 text-gray-700">-</td>
                                        <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $row->sunset_time  ? \Carbon\Carbon::parse($row->sunset_time)->format('H:i')  . ' WIT' : '-' }}</td>
                                        <td class="px-5 py-3 text-gray-700">{{ $row->azimuth_sunset ?? '-' }}</td>
                                        <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $row->dusk_time    ? \Carbon\Carbon::parse($row->dusk_time)->format('H:i')    . ' WIT' : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="px-5 py-3 border-t border-gray-100 text-xs text-gray-400">
                            Menampilkan {{ $sunrisesTable->count() }} data untuk
                            {{ $months[$selectedMonth] ?? '' }} {{ $year ?? date('Y') }}
                            — Wilayah: <span class="font-medium text-gray-600">{{ $location }}</span>
                        </div>
                    @else
                        <div class="py-20 text-center text-gray-400">
                            <div class="text-4xl mb-3">🌅</div>
                            <p class="text-sm font-medium">Tidak ada data TTM untuk filter yang dipilih.</p>
                            <p class="text-xs mt-1 text-gray-300">Coba ubah wilayah, bulan, atau tahun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ============================================================
     PANEL: Peta Sambaran Petir
     ============================================================ --}}
<div id="panel-petir" class="panel-section hidden">

    {{-- Hero Header --}}
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Peta Sambaran Petir</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Informasi distribusi dan kerapatan sambaran petir di wilayah Papua Tengah dan sekitarnya,
                tersedia dalam periode dasarian maupun bulanan.
            </p>
        </div>
    </div>

    @php
        $monthNamesFull = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $currentMonthNum = (int) date('n');
        $currentYearNum  = (int) date('Y');
    @endphp

    {{-- ════════════════════════════════════════════════════════════
         SECTION A: DASARIAN
         ════════════════════════════════════════════════════════════ --}}
    <section class="py-8 lg:py-10 border-b-4 border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section heading --}}
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800">Peta Sambaran Petir Wilayah Papua Tengah</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Data per dasarian (10 harian)</p>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="bg-white rounded-2xl shadow-sm px-6 py-5 mb-5">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm font-medium text-gray-500 mr-1">Periode:</span>

                    <div class="relative">
                        <select id="das-month" onchange="loadDasarianData()"
                            class="bg-gray-100 rounded-lg px-4 py-2 pr-8 text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-bmkg-blue/30 border border-gray-200 hover:bg-gray-50 transition cursor-pointer appearance-none">
                            @foreach($monthNamesFull as $num => $name)
                                <option value="{{ $num }}" @selected($num == $currentMonthNum)>{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 9l6 6 6-6" stroke-width="2"/></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select id="das-year" onchange="loadDasarianData()"
                            class="bg-gray-100 rounded-lg px-4 py-2 pr-8 text-sm text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-bmkg-blue/30 border border-gray-200 hover:bg-gray-50 transition cursor-pointer appearance-none">
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" @selected($y == $currentYearNum)>{{ $y }}</option>
                            @endfor
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 9l6 6 6-6" stroke-width="2"/></svg>
                        </div>
                    </div>

                    <span class="text-gray-300 hidden sm:inline">|</span>

                    {{-- Dasarian I / II / III pills --}}
                    <div class="flex items-center bg-gray-100 rounded-xl p-1 gap-1">
                        @foreach([1 => 'Dasarian I', 2 => 'Dasarian II', 3 => 'Dasarian III'] as $d => $dlabel)
                            <button id="das-btn-{{ $d }}" onclick="setDas({{ $d }})"
                                class="das-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-150
                                    {{ $d === 1 ? 'bg-bmkg-blue text-white shadow-sm' : 'text-gray-600 hover:text-gray-800' }}">
                                {{ $dlabel }}
                            </button>
                        @endforeach
                    </div>

                    <span id="das-period-badge" class="ml-auto text-xs font-semibold text-bmkg-blue bg-blue-50 border border-blue-100 rounded-full px-3 py-1 whitespace-nowrap">
                        {{ $monthNamesFull[$currentMonthNum] }} {{ $currentYearNum }} – Dasarian I
                    </span>
                </div>
            </div>

            {{-- Loading --}}
            <div id="das-loading" class="hidden bg-white rounded-2xl shadow-sm p-14 text-center">
                <div class="inline-flex items-center gap-3 text-gray-400">
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span class="text-sm font-medium">Memuat data dasarian...</span>
                </div>
            </div>

            {{-- Empty --}}
            <div id="das-empty" class="hidden bg-white rounded-2xl shadow-sm p-14 text-center">
                <div class="text-4xl mb-3">⚡</div>
                <p class="text-sm font-medium text-gray-500">Tidak ada data untuk periode dasarian yang dipilih.</p>
                <p class="text-xs mt-1 text-gray-400">Coba ubah bulan, tahun, atau pilihan dasarian.</p>
            </div>

            {{-- Data grid --}}
            <div id="das-data" class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Map --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 pt-5 pb-3 border-b border-gray-50 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-gray-800 text-sm">Peta Kerapatan Petir</h3>
                            <p id="das-map-subtitle" class="text-xs text-gray-400 mt-0.5">—</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs text-gray-400 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" stroke-width="1.5"/></svg>
                            Papua Tengah
                        </span>
                    </div>
                    <div class="flex-1 bg-gray-50 flex items-center justify-center min-h-64 p-4">
                        <div id="das-map-noimg" class="text-center hidden">
                            <div class="text-4xl mb-2 opacity-30">🗺️</div>
                            <p class="text-xs text-gray-400">Peta belum tersedia.</p>
                        </div>
                        <img id="das-map-img" src="" alt="Peta Kerapatan Petir Dasarian"
                            class="max-w-full max-h-80 object-contain rounded-lg hidden"
                            onerror="this.classList.add('hidden'); document.getElementById('das-map-noimg').classList.remove('hidden')" />
                    </div>
                    <div class="px-6 py-3 border-t border-gray-50">
                        <p id="das-map-updated" class="text-xs text-gray-400 italic">—</p>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
                    <div class="flex border-b border-gray-100">
                        <button id="das-tab-sub" onclick="switchDasChart('sub')"
                            class="das-chart-tab flex-1 px-4 py-3.5 text-sm font-semibold border-b-2 border-bmkg-blue text-bmkg-blue transition-all -mb-px whitespace-nowrap">
                            Per Kecamatan
                        </button>
                        <button id="das-tab-daily" onclick="switchDasChart('daily')"
                            class="das-chart-tab flex-1 px-4 py-3.5 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all -mb-px whitespace-nowrap">
                            Per Tanggal
                        </button>
                    </div>

                    <div id="das-panel-sub" class="flex-1 px-3 py-4">
                        <div id="das-sub-nodata" class="hidden h-56 flex items-center justify-center text-xs text-gray-400">Tidak ada data kecamatan.</div>
                        <canvas id="das-chart-sub" style="max-height:300px;"></canvas>
                    </div>
                    <div id="das-panel-daily" class="flex-1 px-3 py-4 hidden">
                        <div id="das-daily-nodata" class="hidden h-56 flex items-center justify-center text-xs text-gray-400">Tidak ada data harian.</div>
                        <canvas id="das-chart-daily" style="max-height:300px;"></canvas>
                    </div>

                    <div class="px-5 pb-4 pt-2 flex items-center justify-between border-t border-gray-50">
                        <div class="flex items-center gap-1.5">
                            <div id="das-dot-sub"   class="w-2 h-2 rounded-full bg-bmkg-blue transition-all"></div>
                            <div id="das-dot-daily" class="w-2 h-2 rounded-full bg-gray-300 transition-all"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="prevDasChart()" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 19l-7-7 7-7" stroke-width="2"/></svg>
                            </button>
                            <button onclick="nextDasChart()" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- end #das-data --}}
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════
         SECTION B: BULANAN
         ════════════════════════════════════════════════════════════ --}}
    <section class="py-8 lg:py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section heading --}}
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1 h-7 bg-teal-500 rounded-full flex-shrink-0"></div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800">Peta Sambaran Petir Wilayah Papua Tengah</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Data bulanan (30 harian)</p>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="bg-white rounded-2xl shadow-sm px-6 py-5 mb-5">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm font-medium text-gray-500 mr-1">Periode:</span>

                    <div class="relative">
                        <select id="bul-month" onchange="loadBulananData()"
                            class="bg-gray-100 rounded-lg px-4 py-2 pr-8 text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/30 border border-gray-200 hover:bg-gray-50 transition cursor-pointer appearance-none">
                            @foreach($monthNamesFull as $num => $name)
                                <option value="{{ $num }}" @selected($num == $currentMonthNum)>{{ $name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 9l6 6 6-6" stroke-width="2"/></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select id="bul-year" onchange="loadBulananData()"
                            class="bg-gray-100 rounded-lg px-4 py-2 pr-8 text-sm text-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500/30 border border-gray-200 hover:bg-gray-50 transition cursor-pointer appearance-none">
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" @selected($y == $currentYearNum)>{{ $y }}</option>
                            @endfor
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 9l6 6 6-6" stroke-width="2"/></svg>
                        </div>
                    </div>

                    <span id="bul-period-badge" class="ml-auto text-xs font-semibold text-teal-700 bg-teal-50 border border-teal-100 rounded-full px-3 py-1 whitespace-nowrap">
                        {{ $monthNamesFull[$currentMonthNum] }} {{ $currentYearNum }} – Bulanan
                    </span>
                </div>
            </div>

            {{-- Loading --}}
            <div id="bul-loading" class="hidden bg-white rounded-2xl shadow-sm p-14 text-center">
                <div class="inline-flex items-center gap-3 text-gray-400">
                    <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span class="text-sm font-medium">Memuat data bulanan...</span>
                </div>
            </div>

            {{-- Empty --}}
            <div id="bul-empty" class="hidden bg-white rounded-2xl shadow-sm p-14 text-center">
                <div class="text-4xl mb-3">⚡</div>
                <p class="text-sm font-medium text-gray-500">Tidak ada data untuk periode bulanan yang dipilih.</p>
                <p class="text-xs mt-1 text-gray-400">Coba ubah bulan atau tahun.</p>
            </div>

            {{-- Data grid --}}
            <div id="bul-data" class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Map --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 pt-5 pb-3 border-b border-gray-50 flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-gray-800 text-sm">Peta Kerapatan Petir</h3>
                            <p id="bul-map-subtitle" class="text-xs text-gray-400 mt-0.5">—</p>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs text-gray-400 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 flex-shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" stroke-width="1.5"/></svg>
                            Papua Tengah
                        </span>
                    </div>
                    <div class="flex-1 bg-gray-50 flex items-center justify-center min-h-64 p-4">
                        <div id="bul-map-noimg" class="text-center hidden">
                            <div class="text-4xl mb-2 opacity-30">🗺️</div>
                            <p class="text-xs text-gray-400">Peta belum tersedia.</p>
                        </div>
                        <img id="bul-map-img" src="" alt="Peta Kerapatan Petir Bulanan"
                            class="max-w-full max-h-80 object-contain rounded-lg hidden"
                            onerror="this.classList.add('hidden'); document.getElementById('bul-map-noimg').classList.remove('hidden')" />
                    </div>
                    <div class="px-6 py-3 border-t border-gray-50">
                        <p id="bul-map-updated" class="text-xs text-gray-400 italic">—</p>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col">
                    <div class="flex border-b border-gray-100">
                        <button id="bul-tab-sub" onclick="switchBulChart('sub')"
                            class="bul-chart-tab flex-1 px-4 py-3.5 text-sm font-semibold border-b-2 border-teal-500 text-teal-600 transition-all -mb-px whitespace-nowrap">
                            Per Kecamatan
                        </button>
                        <button id="bul-tab-daily" onclick="switchBulChart('daily')"
                            class="bul-chart-tab flex-1 px-4 py-3.5 text-sm font-semibold border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition-all -mb-px whitespace-nowrap">
                            Per Tanggal
                        </button>
                    </div>

                    <div id="bul-panel-sub" class="flex-1 px-3 py-4">
                        <div id="bul-sub-nodata" class="hidden h-56 flex items-center justify-center text-xs text-gray-400">Tidak ada data kecamatan.</div>
                        <canvas id="bul-chart-sub" style="max-height:300px;"></canvas>
                    </div>
                    <div id="bul-panel-daily" class="flex-1 px-3 py-4 hidden">
                        <div id="bul-daily-nodata" class="hidden h-56 flex items-center justify-center text-xs text-gray-400">Tidak ada data harian.</div>
                        <canvas id="bul-chart-daily" style="max-height:300px;"></canvas>
                    </div>

                    <div class="px-5 pb-4 pt-2 flex items-center justify-between border-t border-gray-50">
                        <div class="flex items-center gap-1.5">
                            <div id="bul-dot-sub"   class="w-2 h-2 rounded-full bg-teal-500 transition-all"></div>
                            <div id="bul-dot-daily" class="w-2 h-2 rounded-full bg-gray-300 transition-all"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="prevBulChart()" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 19l-7-7 7-7" stroke-width="2"/></svg>
                            </button>
                            <button onclick="nextBulChart()" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M9 5l7 7-7 7" stroke-width="2"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- end #bul-data --}}
        </div>
    </section>

</div>{{-- end #panel-petir --}}

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
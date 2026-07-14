{{-- ============================================================
     PANEL: Terbit-Terbenam Matahari (TTM)
     Data: $sunrisesTable, $month, $year, $location, $ttmRegions (from HomeController::informasiGeofisika)
     ============================================================ --}}
<div id="panel-ttm" class="panel-section">
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Terbit-Terbenam Matahari</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Informasi terbit-terbenam Matahari adalah data waktu matahari terbit, transit, dan terbenam
                beserta azimut untuk setiap wilayah di Provinsi Papua Tengah.
            </p>
        </div>
    </div>
    <section class="py-8 lg:py-10 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden p-3 border border-gray-100">
                <div class="px-6 pt-5 pb-6">
                    <form method="GET" action="{{ route('informasi-geofisika') }}" id="ttm-form">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <div class="flex items-center gap-3 flex-1 justify-between">
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
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.sunrise.index') }}"
                                        class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Kelola Data TTM
                                        </a>
                                    @endif
                                @endauth
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
                                        <td class="px-5 py-3 text-gray-700">{{ $row->transit_altitude }}</td>
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

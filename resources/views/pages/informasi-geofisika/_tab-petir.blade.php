{{-- ============================================================
     PANEL: Peta Sambaran Petir
     JS for this panel (dasarian/bulanan charts) lives in the @push('scripts')
     block of the parent informasi-geofisika.blade.php.
     ============================================================ --}}
<div id="panel-petir" class="panel-section hidden">

    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
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
    <section class="py-8 lg:py-10 border-gray-100 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section heading --}}
            <div class="flex items-center gap-3 flex-1 justify-between">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                    <div>
                        <h2 class="font-bold text-xl text-gray-800">Peta Sambaran Petir Wilayah Papua Tengah</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Data per dasarian (10 harian)</p>
                    </div>
                </div>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.lightning.index') }}"
                        class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 shadow-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Kelola Peta Petir
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Filter Card --}}
            <div class="bg-white rounded-2xl shadow-sm px-6 py-5 mb-5 border border-gray-100">
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
            <div id="das-empty" class="hidden bg-white rounded-2xl shadow-sm p-14 text-center border border-gray-100">
                <div class="text-4xl mb-3">⚡</div>
                <p class="text-sm font-medium text-gray-500">Tidak ada data untuk periode dasarian yang dipilih.</p>
                <p class="text-xs mt-1 text-gray-400">Coba ubah bulan, tahun, atau pilihan dasarian.</p>
            </div>

            {{-- Data grid --}}
            <div id="das-data" class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Map --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col border border-gray-100">
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
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col border border-gray-100">
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
                        <canvas id="das-chart-sub" class="max-h-[300px]"></canvas>
                    </div>
                    <div id="das-panel-daily" class="flex-1 px-3 py-4 hidden">
                        <div id="das-daily-nodata" class="hidden h-56 flex items-center justify-center text-xs text-gray-400">Tidak ada data harian.</div>
                        <canvas id="das-chart-daily" class="max-h-[300px]"></canvas>
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
    <section class="py-8 lg:py-10 bg-white">
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
            <div class="bg-white rounded-2xl shadow-sm px-6 py-5 mb-5 borer border-gray-100">
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
            <div id="bul-empty" class="hidden bg-white rounded-2xl shadow-sm p-14 text-center border border-gray-100">
                <div class="text-4xl mb-3">⚡</div>
                <p class="text-sm font-medium text-gray-500">Tidak ada data untuk periode bulanan yang dipilih.</p>
                <p class="text-xs mt-1 text-gray-400">Coba ubah bulan atau tahun.</p>
            </div>

            {{-- Data grid --}}
            <div id="bul-data" class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Map --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col border border-gray-100">
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
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col border border-gray-100">
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
                            <canvas id="bul-chart-sub" class="max-h-[300px]"></canvas>
                        </div>
                        <div id="bul-panel-daily" class="flex-1 px-3 py-4 hidden">
                            <div id="bul-daily-nodata" class="hidden h-56 flex items-center justify-center text-xs text-gray-400">Tidak ada data harian.</div>
                            <canvas id="bul-chart-daily" class="max-h-[300px]"></canvas>
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

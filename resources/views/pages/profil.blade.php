@extends('layouts.app')
@section('title', 'Profil - Stasiun Geofisika Kelas III Nabire')

@section('content')
{{-- Navbar --}}
<div class="border-b border-blue-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex gap-1 overflow-x-auto" id="geo-tabs">
            <a href="{{ route('home') }}" id="tab-beranda"
               class="flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Beranda
            </a>
            <button onclick="switchTab('profil')" id="tab-profil"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Profil Kantor
            </button>
            <button onclick="switchTab('struktur')" id="tab-struktur"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Struktur Organisasi
            </button>
            <button onclick="switchTab('aloptama')" id="tab-aloptama"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Aloptama Geofisika
            </button>
        </nav>
    </div>
</div>


{{--Profil Kantor--}}
<div id="panel-profil" class="panel-section">
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Sejarah --}}
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-teal-500 rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Sejarah</h1>
            </div>
            <p class="text-gray-600 mb-15">Stasiun Geofisika Kelas III Nabire merupakan unit pelaksana teknis (UPT) BMKG yang terletak di Jalan Matoa, Kelurahan Kalibobo, Kabupaten Nabire, Provinsi Papua Tengah (98818). Keberadaan Stasiun Geofisika Kelas III Nabire adalah hasil relokasi dari Stasiun Geofisika Tual dan telah resmi beroperasi di Kabupaten Nabire sejak tahun 2018. Dalam perkembangannya, stasiun ini tidak hanya berfungsi sebagai penyedia informasi meteorologi, klimatologi, dan geofisika setempat, tetapi juga mengemban peran strategis sebagai Koordinator BMKG untuk seluruh wilayah Provinsi Papua Tengah.</p>

            {{-- Visi --}}
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Visi</h1>
            </div>
            <p class="text-gray-600 mb-15">Terwujudnya pelayanan Geofisika yang handal, tanggap dan terpercaya dalam rangka mendukung keselamatan masyarakat serta keberhasilan pembangunan di daerah / Provinsi Papua Tengah</p>
                
            {{-- Misi --}}
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-orange-500 rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Misi</h1>
            </div>
            <ul class="list-disc pl-6 space-y-2 text-gray-600 mb-10">
                <li>Mengamati dan memahami fenomena gempabumi dan tsunami di Daerah / Provinsi Papua Tengah</li>
                <li>Menyediakan data dan pelayanan informasi dan jasa gempabumi dan tsunami yang handal dan terpercaya di Daerah / Provinsi Papua Tengah</li>
                <li>Mengkoordinasi dan memfasilitasi kegiatan dibidang gempabumi dan tsunami di Daerah / Provinsi Papua Tengah</li>
            </ul>
        </div>
    </section>
</div>

{{-- Struktur Organisasi --}}
<div id="panel-struktur" class="panel-section hidden">
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Struktur Organisasi</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Jajaran pegawai pemerintahan di Stasiun Geofisika Kelas III Nabire yang terdiri dari kepala dan tim pegawai fungsional
            </p>
        </div>
    </div>
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @auth
                @if(auth()->user()->is_admin)
                    <div class="mb-6 flex justify-end">
                        <a href="{{ route('admin.staff.index') }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold bg-bmkg-blue text-white px-4 py-2.5 rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Kelola Pegawai
                        </a>
                    </div>
                @endif
            @endauth

            {{-- Kepala --}}
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h1 class="text-2xl lg:text-3xl font-bold text-bmkg-blue">Kepala Kantor</h1>
                </div>
                @if($staffKepala->isNotEmpty())
                    @php $kepala = $staffKepala->first(); @endphp
                    <div class="flex justify-center">
                        <div class="bg-bmkg-lightblue rounded-2xl p-6 w-full max-w-xs text-center flex flex-col items-center gap-4 shadow-sm hover:shadow-md transition-shadow border border-gray-50">
                            @if($kepala->photo)
                                <img src="{{ asset('storage/'.$kepala->photo) }}" class="w-32 h-32 rounded-full object-cover shadow-sm ring-4 ring-gray-50" alt="{{ $kepala->name }}">
                            @else
                                <div class="w-32 h-32 rounded-full bg-white flex items-center justify-center">
                                    <svg class="w-12 h-12 text-bmkg-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            @endif
                            <div>
                                <h2 class="font-bold text-base text-gray-800">{{ $kepala->name }}</h2>
                                <p class="text-sm text-gray-500 mt-1">NIP. {{ $kepala->nip ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-400 text-sm text-center">Belum ada data kepala.</p>
                @endif
            </div>

            {{-- Pegawai Fungsional --}}
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h1 class="text-2xl lg:text-3xl font-bold text-bmkg-blue">Pegawai Fungsional</h1>
                </div>
                @if($staffFungsional->isEmpty())
                    <p class="text-gray-400 text-sm text-center">Belum ada data pegawai fungsional.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($staffFungsional as $s)
                            <div class="bg-bmkg-lightblue rounded-2xl p-6 text-center flex flex-col items-center gap-4 shadow-sm hover:shadow-md transition-shadow border border-gray-50">
                                @if($s->photo)
                                    <img src="{{ asset('storage/'.$s->photo) }}" class="w-24 h-24 rounded-full object-cover shadow-sm ring-4 ring-gray-50" alt="{{ $s->name }}">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-white flex items-center justify-center">
                                        <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <h2 class="font-bold text-base text-gray-800">{{ $s->name }}</h2>
                                    <p class="text-sm text-gray-500 mt-1">NIP. {{ $s->nip ?? '-' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- PPNPN --}}
            <!-- <div>
                <div class="text-center mb-8">
                    <h1 class="text-2xl lg:text-3xl font-bold text-bmkg-blue">Pegawai Pemerintah Non Pegawai Negeri</h1>
                </div>
                @if($staffPpnpn->isEmpty())
                    <p class="text-gray-400 text-sm text-center">Belum ada data PPNPN.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($staffPpnpn as $s)
                            <div class="bg-white rounded-2xl p-6 text-center flex flex-col items-center gap-4 shadow-sm hover:shadow-md transition-shadow border border-gray-50">
                                @if($s->photo)
                                    <img src="{{ asset('storage/'.$s->photo) }}" class="w-24 h-24 rounded-full object-cover shadow-sm ring-4 ring-gray-50" alt="{{ $s->name }}">
                                @else
                                    <div class="w-24 h-24 rounded-full bg-teal-500/10 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <h2 class="font-bold text-base text-gray-800">{{ $s->name }}</h2>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div> -->
        </div>
    </section>

</div>

{{-- Aloptama Geofisika --}}
<div id="panel-aloptama" class="panel-section">
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Alat Operasional Utama Geofisika</h1>
            <p class="text-gray-500 text-sm max-w-3xl mx-auto">
                Alat Operasional Utama (Aloptama) bidang geofisika merupakan peralatan inti yang dioperasikan dan/atau menjadi tanggung jawab
                Stasiun Geofisika Kelas III Nabire dalam mendukung pengamatan, pengolahan, serta diseminasi informasi gempabumi, tsunami,
                dan kebumian lainnya secara cepat dan akurat kepada masyarakat di wilayah Provinsi Papua Tengah.
            </p>
        </div>
    </div>
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Seismometer --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col transition-all duration-250 ease-in-out hover:-translate-y-2 hover:shadow-xl">
                    <div class="relative w-full h-56 pt-3 px-3">
                        <img src="{{ asset('img/seismometer.png') }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                             class="w-full h-full rounded-lg shadow-sm object-cover" alt="Seismometer Site InaTEWS">
                    </div>
                    <div class="p-6 flex flex-col flex-1 ">
                        <div class="flex items-center gap-2.5 mb-1">
                            <span class="flex-shrink-0 w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h3l2-7 3 14 3-11 2 4h3l2-3h4"/></svg>
                            </span>
                            <h2 class="font-heading font-semibold text-xl text-gray-800">Seismometer</h2>
                        </div>
                        <p class="text-sm font-medium text-blue-600 mb-3">Mendeteksi &amp; merekam getaran gempabumi secara real-time</p>
                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            Seismometer adalah alat utama yang digunakan untuk mendeteksi dan merekam getaran gempabumi secara terus-menerus
                            (continuous) dan real-time. Sebagai bagian dari jaringan Indonesia Tsunami Early Warning System (InaTEWS), sensor
                            ini berperan penting dalam mendukung pemantauan, analisis parameter gempabumi (lokasi, kedalaman, dan magnitudo),
                            serta diseminasi informasi peringatan dini tsunami kepada masyarakat di wilayah Papua Tengah. Data getaran yang
                            terekam dikirimkan secara real-time ke Pusat Gempabumi dan Tsunami BMKG untuk diolah lebih lanjut.
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">9 Site Seismometer Tanggung Jawab Stasiun</p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">SWPM</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">IWPI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">NBPI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">SRPI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">BAKI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">ERPI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">WWPI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">MIPI</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">SJPM</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Accelerograph --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col transition-all duration-250 ease-in-out hover:-translate-y-2 hover:shadow-xl">
                    <div class="relative w-full h-56 pt-3 px-3">
                        <img src="{{ asset('img/accelerograph.png') }}"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                             class="w-full h-full rounded-lg shadow-sm object-cover" alt="Accelerograph">
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <span class="flex-shrink-0 w-9 h-9 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 18a8 8 0 1116 0M12 18l4-5"/><circle cx="12" cy="18" r="1" fill="currentColor" stroke="none"/></svg>
                            </span>
                            <h2 class="font-heading font-semibold text-xl text-gray-800">Accelerograph</h2>
                        </div>
                        <p class="text-sm font-medium text-orange-600 mb-3">Merekam percepatan tanah (ground acceleration)</p>
                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            Accelerograph merupakan instrumen yang berfungsi merekam percepatan tanah akibat getaran gempabumi, khususnya pada
                            wilayah dengan tingkat kegempaan tinggi. Data yang dihasilkan digunakan untuk mengkaji potensi tingkat kerusakan
                            akibat gempabumi serta menjadi salah satu parameter penting dalam analisis mikrozonasi dan mitigasi bencana di
                            wilayah Papua Tengah.
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">1 Site Accelerograph (Non-Collocated)</p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-orange-50 text-orange-600">ERPN</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lightning Detector --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col transition-all duration-250 ease-in-out hover:-translate-y-2 hover:shadow-xl">
                    <div class="relative w-full h-56 pt-3 px-3">
                        <img src="{{ asset('img/ld.png') }}"
                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                             class="w-full h-full rounded-lg shadow-sm object-cover" alt="Lightning Detector">
                        <div class="hidden w-full h-full items-center justify-center text-gray-400 text-sm bg-gray-100">Foto Lightning Detector</div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <span class="flex-shrink-0 w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2L3 14h7l-1 8 10-12h-7l1-8z"/></svg>
                            </span>
                            <h2 class="font-heading font-semibold text-xl text-gray-800">Lightning Detector</h2>
                        </div>
                        <p class="text-sm font-medium text-amber-600 mb-3">Mendeteksi lokasi &amp; intensitas sambaran petir</p>
                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            Lightning Detector merupakan peralatan yang digunakan untuk mendeteksi dan memantau aktivitas sambaran petir di
                            suatu wilayah. Alat ini mampu mendeteksi sambaran petir dengan akurasi tinggi, termasuk lokasi, intensitas, jenis,
                            dan arah sambaran petir. Informasi yang dihasilkan dimanfaatkan untuk mendukung penyediaan data serta peringatan
                            dini terhadap potensi bahaya petir, sehingga membantu masyarakat dan instansi terkait dalam upaya kesiapsiagaan
                            menghadapi cuaca ekstrem.
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Lokasi Site</p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-600">Stasiun Geofisika Kelas III Nabire</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-600">Stasiun Meteorologi Kelas III Mozez Kilangin Mimika</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- WRS-NG --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col transition-all duration-250 ease-in-out hover:-translate-y-2 hover:shadow-xl">
                    <div class="relative w-full h-56 pt-3 px-3">
                        <img src="{{ asset('img/wrs.png') }}"
                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                             class="w-full h-full rounded-lg shadow-sm object-cover" alt="WRS-NG">
                        <div class="hidden w-full h-full items-center justify-center text-gray-400 text-sm bg-gray-100">Foto WRS-NG</div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2.5 mb-1">
                            <span class="flex-shrink-0 w-9 h-9 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.53 16.11a6 6 0 016.95 0"/><circle cx="12" cy="20" r="1" fill="currentColor" stroke="none"/></svg>
                            </span>
                            <h2 class="font-heading font-semibold text-xl text-gray-800">WRS-NG</h2>
                        </div>
                        <p class="text-sm font-medium text-teal-600 mb-3">Menerima &amp; menyalurkan peringatan dini tsunami</p>
                        <p class="text-gray-600 text-sm leading-relaxed mb-5">
                            WRS-NG atau Warning Receiver System - New Generation merupakan sistem penerima peringatan yang digunakan untuk
                            menerima dan menampilkan informasi gempabumi serta peringatan dini tsunami secara otomatis dan real-time. Alat
                            ini menjadi salah satu sarana utama dalam diseminasi informasi yang mendukung kecepatan dan keakuratan
                            penyampaian peringatan dini kepada pemangku kepentingan, khususnya di wilayah Papua Tengah.
                        </p>
                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Lokasi Site</p>
                            <div class="flex flex-wrap gap-1.5">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-600">Stasiun Geofisika Kelas III Nabire</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-600">Kantor BPBD Kabupaten Nabire</span>
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-teal-50 text-teal-600">Kantor BPBD Kabupaten Supiori</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<script>
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
        const url = new URL(window.location.href);
        url.searchParams.set('tab', name);
        window.history.replaceState({}, '', url.toString());
    }
    (function () {
        const params = new URLSearchParams(window.location.search);
        switchTab(params.get('tab') || 'profil');
    })();
</script>
@endsection
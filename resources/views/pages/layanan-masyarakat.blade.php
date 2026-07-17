@extends('layouts.app')
@section('title', 'Layanan Masyarakat - Stasiun Geofisika Kelas III Nabire')
@section('content')

<style>
    input, select, textarea, button, .tab-btn, #dynamic-form, #dynamic-form * {
        cursor: pointer;
    }
</style>

{{-- Navbar --}}
<div class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex gap-1 overflow-x-auto" id="geo-tabs">
                <a
                    href="{{ route('home') }}"
                    id="tab-beranda"
                    class="flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                    Beranda
                </a>
                <button
                    onclick="switchTab('data')"
                    id="tab-data"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                    Layanan Permintaan Data
                </button>
                <button
                    onclick="switchTab('pengaduan')"
                    id="tab-pengaduan"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                    Layanan Pengaduan &amp; SKM
                </button>
            </nav>
    </div>
</div>


{{-- ================= PANEL: LAYANAN PERMINTAAN DATA ================= --}}
<section id="panel-data" class="panel-section py-10 lg:py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-4">
                <p class="text-sm font-semibold mb-1">Harap perbaiki kesalahan berikut:</p>
                <ul class="list-disc list-inside text-sm space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-8 items-start">

            {{-- ================= LEFT SIDE ================= --}}
            <div class="space-y-4">
                {{-- Accordion 1 --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <button onclick="toggleAccordion('nol')" class="w-full text-left p-6 flex justify-between items-center">
                        <h2 class="font-bold text-base text-bmkg-blue">
                            Syarat & Ketentuan Tarif Nol Rupiah
                        </h2>
                        <span id="icon-nol">+</span>
                    </button>

                    <div id="content-nol" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6 text-sm text-gray-600 space-y-4">

                        <div class="border-t border-gray-200 pt-3">
                            <h3 class="font-semibold text-gray-800 mb-2">Lingkup Kegiatan:</h3>
                            <ul class="list-disc ml-5 space-y-1">
                                <li>Kewajiban/komitmen internasional</li>
                                <li>Penganggulangan bencana</li>
                                <li>Kegiatan keagamaan</li>
                                <li>Pertahanan dan keamanan</li>
                                <li>Pendidikan & penelitian non-komersial</li>
                                <li>Kegiatan pemerintah (kerjasama BMKG)</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">Syarat Dokumen:</h3>
                            <ul class="list-disc ml-5 space-y-1">
                                <li>Surat pengantar instansi/sekolah</li>
                                <li>Surat permohonan informasi</li>
                                <li>Surat Pernyataan tidak menyalahgunakan informasi</li>
                                <li>Proposal skripsi/kegiatan/penelitian</li>
                            </ul>
                        </div>
                        <div>
                            <button onclick="openPdfModal()" class="text-blue-600 hover:text-blue-800 hover:underline text-xs italic transition-colors text-left cursor-pointer">
                                Sumber: Perka BMKG No 12 Tahun 2019
                            </button>
                        </div>

                        <div id="documentModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
                            <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
                                <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
                                    <h3 class="font-semibold text-gray-800">Dokumen: Perka BMKG No 12 Tahun 2019</h3>
                                    <button onclick="closePdfModal()" class="text-gray-500 hover:text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex-1 w-full bg-gray-100">
                                    <iframe 
                                        src="https://drive.google.com/file/d/1HkbtFvnA6V6HI172YuLJhhRRsMbwBqbk/preview" 
                                        class="w-full h-full border-0"
                                        allow="autoplay">
                                    </iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Accordion 2 --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <button onclick="toggleAccordion('tarif')" class="w-full text-left p-6 flex justify-between items-center">
                        <h2 class="font-bold text-base text-bmkg-blue">
                            Ketersediaan Data di Stageof Nabire
                        </h2>
                        <span id="icon-tarif">+</span>
                    </button>

                    <div id="content-tarif" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out px-6 text-sm text-gray-600">
                        <div class="space-y-6 pt-3 border-t border-gray-200">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">A. Informasi Khusus</h3>

                                <table class="w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="py-2">Peta Kegempaan</td>
                                            <td class="py-2 text-right">Rp250.000</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Peta Percepatan Tanah</td>
                                            <td class="py-2 text-right">Rp250.000</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Klaim Asuransi</td>
                                            <td class="py-2 text-right">Rp185.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="">
                                <h3 class="font-semibold text-gray-800 mb-2">B. Sesuai Permintaan</h3>

                                <table class="w-full text-sm">
                                    <tbody class="divide-y divide-gray-100">
                                        <tr><td class="py-2">Variasi Magnet Bumi</td><td class="py-2 text-right">Rp300.000</td></tr>
                                        <tr><td class="py-2">Peta Kerawanan Petir</td><td class="py-2 text-right">Rp200.000</td></tr>
                                        <tr><td class="py-2">Waktu Terbit/Terbenam</td><td class="py-2 text-right">Rp50.000</td></tr>
                                        <tr><td class="py-2">Almanak BMKG</td><td class="py-2 text-right">Rp150.000</td></tr>
                                        <tr><td class="py-2">Peta Hilal</td><td class="py-2 text-right">Rp150.000</td></tr>
                                        <tr><td class="py-2">Titik Gravitasi</td><td class="py-2 text-right">Rp150.000</td></tr>
                                        <tr><td class="py-2">Kejadian Petir</td><td class="py-2 text-right">Rp75.000</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200 flex flex-col gap-2 pb-4">
                            <p class="text-gray-500 text-xs">Untuk informasi lebih lanjut, silakan lihat tautan berikut:</p>
                            <div class="flex flex-col gap-1 items-start mt-2">
                                <button type="button" onclick="openTarifModal()" class="text-blue-600 hover:text-blue-800 hover:underline text-xs italic transition-colors text-left cursor-pointer">
                                    &rarr; Tarif Layanan Meteorologi Klimatologi Geofisika lainnya 
                                </button>
                                
                                <button type="button" onclick="openPdfModal()" class="text-blue-600 hover:text-blue-800 hover:underline text-xs italic transition-colors text-left cursor-pointer">
                                    &rarr; Sumber: PP No 47 Tahun 2018
                                </button>
                            </div>

                            @include('pages.modal-tarif')

                            <div id="documentModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
                                <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
                                    
                                    <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
                                        <h3 class="font-semibold text-gray-800">Dokumen: PP No 47 Tahun 2018</h3>
                                        <button onclick="closePdfModal()" class="text-gray-500 hover:text-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex-1 w-full bg-gray-100">
                                        <iframe 
                                            src="https://drive.google.com/file/d/1Cvl-kUk0_GuUms1qSCAR-3R2XUEU_EBp/preview" 
                                            class="w-full h-full border-0"
                                            allow="autoplay">
                                        </iframe>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- ================= RIGHT SIDE (FORM) ================= --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h2 class="font-bold text-3xl text-bmkg-blue mb-6">Form Permohonan Data</h2>

                <form method="POST"
                      action="{{ route('layanan-masyarakat.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- ── Kolom Kiri: Identitas ── --}}
                        <div class="space-y-4">
                            <div>
                                <input type="text"
                                       name="nama_lengkap"
                                       value="{{ old('nama_lengkap') }}"
                                       placeholder="Nama Lengkap *"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm @error('nama_lengkap') border-red-400 @enderror">
                                @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <input type="text"
                                       name="nik"
                                       value="{{ old('nik') }}"
                                       placeholder="NIK"
                                       maxlength="16"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                            </div>

                            <div>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="Email"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm @error('email') border-red-400 @enderror">
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <input type="text"
                                       name="no_hp"
                                       value="{{ old('no_hp') }}"
                                       placeholder="No. HP / WhatsApp *"
                                       inputmode="numeric"
                                       pattern="^0\d{9,12}$"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm @error('no_hp') border-red-400 @enderror">
                                @error('no_hp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <input type="text"
                                       name="instansi"
                                       value="{{ old('instansi') }}"
                                       placeholder="Instansi / Sekolah / Perusahaan *"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm @error('instansi') border-red-400 @enderror">
                                @error('instansi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <textarea name="alamat"
                                          placeholder="Alamat"
                                          rows="3"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        {{-- ── Kolom Kanan: Permohonan ── --}}
                        <div class="space-y-4">

                            {{-- Jenis Data yang Diminta (Blank Text Input) --}}
                            <div>
                                <input type="text"
                                    name="jenis_data"
                                    value="{{ old('jenis_data') }}"
                                    placeholder="Masukkan Jenis Data yang Diminta *"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm @error('jenis_data') border-red-400 @enderror">
                                @error('jenis_data')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Jenis Permohonan --}}
                            <div>
                                <select name="jenis_permohonan"
                                        id="jenis_permohonan"
                                        onchange="handleJenis(this.value)"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm @error('jenis_permohonan') border-red-400 @enderror">
                                    <option value="">Pilih Jenis Permohonan *</option>
                                    <option value="pnbp" {{ old('jenis_permohonan') === 'pnbp' ? 'selected' : '' }}>PNBP</option>
                                    <option value="nol"  {{ old('jenis_permohonan') === 'nol'  ? 'selected' : '' }}>Tarif Nol Rupiah</option>
                                </select>
                                @error('jenis_permohonan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Dynamic Content (rendered by JS, pre-filled on validation fail) --}}
                            <div id="dynamic-form" class="text-sm text-gray-600"></div>

                            <button type="submit"
                                    formtarget="_blank"
                                    class="w-full bg-bmkg-blue text-white py-2.5 rounded-lg hover:opacity-90 transition font-medium">
                                Kirim Permohonan
                            </button>

                            <p class="text-xs text-gray-400 text-center">
                                * Kolom wajib diisi. Permohonan akan dikirim ke kantor dan tim kami akan menghubungi Anda.
                            </p>
                        </div>
                    </div>
                </form>
            </div>  
        </div>
        <img src="{{ asset('img/layanan.png') }}" alt="Panduan Layanan" class="mt-10 w-full h-auto rounded-2xl shadow-sm">
    </div>
</section>


{{-- ================= PANEL: LAYANAN PENGADUAN & SKM ================= --}}
<section id="panel-pengaduan" class="panel-section hidden py-10 lg:py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <h2 class="text-2xl lg:text-3xl font-bold text-bmkg-blue">Layanan Pengaduan &amp; SKM</h2>
            <p class="text-sm text-gray-500 mt-2 max-w-xl mx-auto">
                Sampaikan pengaduan Anda atau berikan penilaian terhadap kualitas pelayanan kami melalui kanal resmi berikut.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Kontak Telepon --}}
            <div class="bg-lightblue rounded-2xl p-6 flex flex-col items-start gap-4 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-12 h-12 rounded-full bg-bmkg-blue/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-bmkg-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-base text-gray-800 mb-1">Layanan Pengaduan (Telepon)</h3>
                    <p class="text-sm text-gray-500 mb-3">Hubungi kami langsung untuk pengaduan yang bersifat mendesak.</p>
                   <a href="https://wa.me/6282190796122"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-bmkg-blue hover:underline">
                        +62 821-9079-6122
                    </a>    
                </div>
            </div>

            {{-- Kontak Email --}}
            <div class="bg-lightblue rounded-2xl p-6 flex flex-col items-start gap-4 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                <div class="w-12 h-12 rounded-full bg-bmkg-blue/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-bmkg-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-base text-gray-800 mb-1">Layanan Pengaduan (Email)</h3>
                    <p class="text-sm text-gray-500 mb-3">Kirimkan pengaduan Anda secara tertulis melalui email resmi kami.</p>
                    <a href="mailto:stageof.nabire@bmkg.go.id"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-bmkg-blue hover:underline break-all">
                        stageof.nabire@bmkg.go.id
                    </a>
                </div>
            </div>

            {{-- Survei Kepuasan Masyarakat --}}
            <div class="bg-bmkg-blue rounded-2xl p-6 flex flex-col items-start gap-4 shadow-sm hover:shadow-md transition-shadow text-white">
                <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-base mb-1">Survei Kepuasan Masyarakat</h3>
                    <p class="text-sm text-white/80 mb-4">Bantu kami meningkatkan kualitas layanan dengan mengisi SKM periode berjalan.</p>
                </div>
                <a id="skm-survey-link"
                   href="#"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 bg-white text-bmkg-blue text-sm font-semibold px-5 py-2.5 rounded-lg hover:opacity-90 transition w-full">
                    Isi Survei Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

        </div>

        <div class="mt-10 rounded-3xl border border-gray-200 bg-gray-50 p-6 lg:p-8 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-bmkg-blue">Kotak Saran</h3>
                    <p class="mt-2 text-sm text-gray-600">Berikan saran, rekomendasi, atau komentar Anda untuk membantu kami meningkatkan layanan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('layanan-masyarakat.saran.store') }}" class="mt-6 space-y-4">
                @csrf
                <textarea name="comment" rows="4" maxlength="1000" placeholder="Tulis saran atau komentar Anda di sini..." class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-700 focus:border-bmkg-blue focus:outline-none focus:ring-2 focus:ring-blue-100" required></textarea>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-bmkg-blue px-5 py-2.5 text-sm font-semibold text-white transition hover:opacity-90">
                        Kirim Saran
                    </button>
                </div>
                @if(session('suggestion_success'))
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('suggestion_success') }}
                    </div>
                @endif
                @error('comment')
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $message }}
                    </div>
                @enderror
            </form>
        </div>
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

    // Default active tab for this page
    (function () {
        const params = new URLSearchParams(window.location.search);
        const tab = params.get('tab') || 'data';
        switchTab(tab);
    })();
</script>


<script>
// ── Accordion ─────────────────────────────────────────────────────────────────
function toggleAccordion(id) {
    const content = document.getElementById('content-' + id);
    const icon = document.getElementById('icon-' + id);

    if (content.classList.contains('max-h-0')) {
        content.classList.remove('max-h-0');
        content.classList.add('max-h-[1000px]', 'pb-6'); // expand
        icon.textContent = '-';
    } else {
        content.classList.add('max-h-0');
        content.classList.remove('max-h-[1000px]', 'pb-6'); // collapse
        icon.textContent = '+';
    }
}

// ── Dynamic form ──────────────────────────────────────────────────────────────
function handleJenis(value) {
    const container = document.getElementById('dynamic-form');
    container.innerHTML = '';

    if (value === 'pnbp') {
        container.innerHTML = `
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">
                    Upload Surat Permohonan Informasi
                    <span class="text-gray-400 font-normal">(PDF/JPG/PNG, maks 5MB)</span>
                </label>
                <input type="file" name="file_surat_permohonan"
                       accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        `;
    } else if (value === 'nol') {
        // Restore old lingkup value on validation error
        const oldLingkup = "{{ old('lingkup_kegiatan') }}";

        container.innerHTML = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lingkup Kegiatan</label>
                    <select id="lingkup" name="lingkup_kegiatan" class="w-full border rounded-lg px-3 py-2 text-sm mt-1">
                        <option value="">Pilih</option>
                        <option value="pendidikan" ${oldLingkup === 'pendidikan' ? 'selected' : ''}>Pendidikan &amp; Penelitian</option>
                        <option value="lainnya"    ${oldLingkup === 'lainnya'    ? 'selected' : ''}>Lainnya</option>
                    </select>
                </div>
                <div id="dokumen-nol" class="space-y-3"></div>
            </div>
        `;

        document.getElementById('lingkup').addEventListener('change', function () {
            handleLingkup(this.value);
        });

        // Re-render docs section if coming back from validation error
        if (oldLingkup) handleLingkup(oldLingkup);
    }
}

function handleLingkup(value) {
    const el = document.getElementById('dokumen-nol');

    // reset first
    el.innerHTML = '';

    if (value === '') return;

    let html = `
        <div>
            <label class="block text-sm font-medium">Surat Pengantar
                <span class="text-gray-400 font-normal">(PDF/JPG/PNG, maks 5MB)</span>
            </label>
            <input type="file" name="file_surat_pengantar" accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium">Surat Permohonan Informasi
                <span class="text-gray-400 font-normal">(PDF/JPG/PNG, maks 5MB)</span>
            </label>
            <input type="file" name="file_surat_permohonan" accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
        </div>
    `;

    if (value === 'pendidikan') {
        html += `
            <div>
                <label class="block text-sm font-medium">Surat Pernyataan
                    <span class="text-gray-400 font-normal">(PDF/JPG/PNG, maks 5MB)</span>
                </label>
                <input type="file" name="file_surat_pernyataan" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Proposal Penelitian
                    <span class="text-gray-400 font-normal">(PDF/JPG/PNG, maks 5MB)</span>
                </label>
                <input type="file" name="file_proposal" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 mt-1">
            </div>
        `;
    }

    el.innerHTML = html;
}

// Re-render form on page load if there's an old value (validation failed)
(function () {
    const oldJenis = "{{ old('jenis_permohonan') }}";
    if (oldJenis) handleJenis(oldJenis);
})();
</script>

<script>
    const modal = document.getElementById('documentModal');
    const modalContent = document.getElementById('modalContent');

    function openPdfModal() {
        // Show the modal container
        modal.classList.remove('hidden');
        
        // Slight delay to allow display:block to apply before animating opacity/scale
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closePdfModal() {
        // Start exit animation
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        // Wait for animation to finish before hiding completely
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300); // 300ms matches the Tailwind duration-300 class
    }

    // Optional: Close modal if user clicks outside the white box (on the dark background)
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closePdfModal();
        }
    });
</script>

<script>
    // --- Script untuk Modal Tarif PTSP BMKG ---
    const tModal = document.getElementById('tarifModal');
    const tModalContent = document.getElementById('tarifModalContent');

    function openTarifModal() {
        tModal.classList.remove('hidden');
        
        // Delay sedikit agar animasi transisi bekerja
        setTimeout(() => {
            tModal.classList.remove('opacity-0');
            tModalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeTarifModal() {
        tModal.classList.add('opacity-0');
        tModalContent.classList.add('scale-95');
        
        setTimeout(() => {
            tModal.classList.add('hidden');
        }, 300); 
    }

    // Menutup modal jika area gelap di luar box diklik
    tModal.addEventListener('click', function(event) {
        if (event.target === tModal) {
            closeTarifModal();
        }
    });
</script>

<script>
    // ── SKM Survey dynamic link ─────────────────────────────────────────────
    (function () {
        const link = document.getElementById('skm-survey-link');
        if (!link) return;

        const now   = new Date();
        const year  = now.getFullYear();
        const month = now.getMonth() + 1; // 1-12

        // 1 = Jan-Jul (1-7), 2 = Aug-Dec (8-12)
        const periodFlag = (month >= 1 && month <= 7) ? 1 : 2;
        const mm = String(month).padStart(2, '0');

        link.href = `https://eskm.bmkg.go.id/survey/251070/0/${periodFlag}/${year}-${mm}/${year}/0`;
    })();
</script>

@endsection
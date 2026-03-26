@extends('layouts.app')
@section('title', 'Layanan Masyarakat - Stasiun Geofisika Kelas III Nabire')
@section('content')

{{-- Navbar --}}
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
                    onclick="switchTab('data')"
                    id="tab-data"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Layanan Permintaan Data
                </button>
            </nav>
    </div>
</div>


<section class="py-10 lg:py-14 mb-80 bg-lightblue">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_2fr] gap-8 items-start">

            {{-- ================= LEFT SIDE ================= --}}
            <div class="space-y-4">
                {{-- Accordion 1 --}}
                <div class="bg-white rounded-2xl shadow-sm">
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
                        <a href="#" class="text-gray-600 text-xs italic">
                            Sumber: Perka BMKG No 12 Tahun 2019
                        </a>

                    </div>
                </div>

                {{-- Accordion 2 --}}
                <div class="bg-white rounded-2xl shadow-sm">
                    <button onclick="toggleAccordion('tarif')" class="w-full text-left p-6 flex justify-between items-center">
                        <h2 class="font-bold text-base text-bmkg-blue">
                            Tarif Layanan Geofisika
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
                                            <td class="py-2 text-right font-medium">Rp250.000</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Peta Percepatan Tanah</td>
                                            <td class="py-2 text-right font-medium">Rp250.000</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">Klaim Asuransi</td>
                                            <td class="py-2 text-right font-medium">Rp185.000</td>
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
                            <a href="#" class="text-gray-600 text-xs italic">
                                 Sumber: PP No 47 Tahun 2018
                                </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ================= RIGHT SIDE (FORM) ================= --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h2 class="font-bold text-3xl text-bmkg-blue mb-6">
                    Form Permohonan Data
                </h2>

                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <input type="text" placeholder="Nama Lengkap" class="w-full border rounded-lg px-4 py-2">
                            <input type="text" placeholder="NIK" class="w-full border rounded-lg px-4 py-2">
                            <input type="email" placeholder="Email" class="w-full border rounded-lg px-4 py-2">
                            <input type="text" placeholder="No. HP" class="w-full border rounded-lg px-4 py-2">
                            <input type="text" placeholder="Instansi" class="w-full border rounded-lg px-4 py-2">
                            <textarea placeholder="Alamat" class="w-full border rounded-lg px-4 py-2"></textarea>
                        </div>
                        <div class="space-y-4">
                            {{-- Jenis Permohonan --}}
                            <select onchange="handleJenis(this.value)" class="w-full border rounded-lg px-4 py-2">
                                <option value="">Pilih Jenis Permohonan</option>
                                <option value="pnbp">PNBP</option>
                                <option value="nol">Tarif Nol Rupiah</option>
                            </select>

                            {{-- Dynamic Content --}}
                            <div id="dynamic-form" class="text-sm text-gray-600"></div>

                            <button type="submit"
                                class="w-full bg-bmkg-blue text-white py-2 rounded-lg hover:opacity-90 transition">
                                Kirim
                            </button>
                        </div>
                    </div>
                </form>

            </div>

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

function handleJenis(value) {
    const container = document.getElementById('dynamic-form');

    // ✅ IMPORTANT: always reset first
    container.innerHTML = '';

    if (value === '') {
        return; // nothing shown
    }

    if (value === 'pnbp') {
        container.innerHTML = `
            <div class="space-y-3">
                <label class="block text-sm font-medium">Upload Surat Permohonan Informasi</label>
                <input type="file" class="w-full border rounded-lg px-3 py-2">
            </div>
        `;
    }

    else if (value === 'nol') {
        container.innerHTML = `
            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium">Lingkup Kegiatan</label>
                    <select id="lingkup"
                        class="w-full border rounded-lg px-3 py-2 mt-1">
                        <option value="">Pilih</option>
                        <option value="pendidikan">Pendidikan & Penelitian</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div id="dokumen-nol" class="space-y-3"></div>

            </div>
        `;

        // ✅ attach event AFTER render (better than inline onchange)
        document.getElementById('lingkup')
            .addEventListener('change', function () {
                handleLingkup(this.value);
            });
    }
}

function handleLingkup(value) {
    const el = document.getElementById('dokumen-nol');

    // ✅ reset first
    el.innerHTML = '';

    if (value === '') return;

    let html = `
        <div>
            <label class="block text-sm font-medium">Surat Pengantar</label>
            <input type="file" class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>

        <div>
            <label class="block text-sm font-medium">Surat Permohonan Informasi</label>
            <input type="file" class="w-full border rounded-lg px-3 py-2 mt-1">
        </div>
    `;

    if (value === 'pendidikan') {
        html += `
            <div>
                <label class="block text-sm font-medium">Surat Pernyataan</label>
                <input type="file" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Proposal Penelitian</label>
                <input type="file" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>
        `;
    }

    el.innerHTML = html;
}
</script>

@endsection

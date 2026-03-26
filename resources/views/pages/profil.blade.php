@extends('layouts.app')
@section('title', 'Profil - Stasiun Geofisika Kelas III Nabire')

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
                    onclick="switchTab('profil')"
                    id="tab-profil"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Profil Kantor
                </button>
                <button
                    onclick="switchTab('visi-misi')"
                    id="tab-visi-misi"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Visi dan Misi
                </button>
                <button
                    onclick="switchTab('struktur')"
                    id="tab-struktur"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Struktur Organisasi
                </button>
            </nav>
    </div>
</div>

<section class="py-10 lg:py-14">
    {{-- Profil Kantor --}}
    <div id="panel-profil" class="panel-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-teal-500 rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Sejarah</h1>
            </div>
            <div>
                <p class="text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi obcaecati esse voluptatibus sed, id perferendis amet suscipit? Dolorum, facere, ad ipsam nisi similique accusantium nemo magnam nulla id, repellat tempora.</p>
            </div>
        </div>
    </div>
    
    {{-- Visi dan Misi --}}
    <div id="panel-visi-misi" class="panel-section hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Visi</h1>
            </div>
            <div>
                <p class="text-gray-500 mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi obcaecati esse voluptatibus sed, id perferendis amet suscipit? Dolorum, facere, ad ipsam nisi similique accusantium nemo magnam nulla id, repellat tempora.</p>
            </div>

            <div class="flex items-center gap-3 py-3 mb-2 border-b border-gray-300">
                <div class="w-1 h-7 bg-orange-500 rounded-full flex-shrink-0"></div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Misi</h1>
            </div>
            <div>
                <p class="text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi obcaecati esse voluptatibus sed, id perferendis amet suscipit? Dolorum, facere, ad ipsam nisi similique accusantium nemo magnam nulla id, repellat tempora.</p>
            </div>
        </div>
    </div>

    {{-- Struktur Organisasi --}}
    <div id="panel-struktur" class="panel-section hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10">
                <div class="flex items-center gap-3 py-4 mb-6 border-b border-gray-300">
                    <div class="w-1 h-7 bg-bmkg-blue rounded-full flex-shrink-0"></div>
                    <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Kepala</h1>
                </div>
                <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                    <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                    <h2 class="font-semibold text-gray-800">Nama</h2>
                    <p class="text-sm text-gray-500">NIP. 123456789</p>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 py-4 mb-6 border-b border-gray-300">
                    <div class="w-1 h-7 bg-orange-500 rounded-full flex-shrink-0"></div>
                    <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Pegawai Fungsional</h1>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                    <div class="bg-blue-100 border-2 border-gray-400 rounded-lg p-4 w-48 text-center shadow">
                        <img src="/placeholder.jpg" class="w-24 h-24 mx-auto rounded-full object-cover mb-3">
                        <h2 class="font-semibold text-gray-800">Nama</h2>
                        <p class="text-sm text-gray-500">NIP. 123456789</p>
                    </div>
                </div>
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
        const tab = params.get('tab') || 'profil';
        switchTab(tab);
    })();
</script>


@endsection
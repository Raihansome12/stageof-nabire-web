@extends('layouts.app')
@section('title', 'Informasi Publik - Stasiun Geofisika Kelas III Nabire')
@section('content')

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
                    onclick="switchTab('berita')"
                    id="tab-berita"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Berita dan Siaran Pers
                </button>
                <button
                    onclick="switchTab('pengumuman')"
                    id="tab-pengumuman"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Pengumuman
                </button>
            </nav>
    </div>
</div>


<section class="py-10 lg:py-14">
    <div id="panel-berita" class="panel-section">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-10 text-center">
                <div class="text-5xl mb-4">📢</div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-3">Berita dan Siaran Pers</h1>
                <p class="text-gray-500">Halaman ini sedang dalam pengembangan.</p>
            </div>
        </div>
    </div>
    
    <div id="panel-pengumuman" class="panel-section hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-10 text-center">
                <div class="text-5xl mb-4">📢</div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-3">Pengumuman</h1>
                <p class="text-gray-500">Halaman ini sedang dalam pengembangan.</p>
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
        const tab = params.get('tab') || 'berita';
        switchTab(tab);
    })();
</script>

@endsection



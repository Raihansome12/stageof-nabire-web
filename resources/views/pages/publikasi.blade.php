@extends('layouts.app')
@section('title', 'Publikasi - Stasiun Geofisika Kelas III Nabire')

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
                    onclick="switchTab('buletin')"
                    id="tab-buletin"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Buletin
                </button>
                <button
                    onclick="switchTab('artikel')"
                    id="tab-artikel"
                    class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap"
                    >
                    Artikel
                </button>
            </nav>
    </div>
</div>

<section class="py-10 lg:py-14">
    <div id="panel-buletin" class="panel-section max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-10">Publikasi</h1>

        {{-- Buletin Bulanan --}}
        <div class="mb-12">
            <h2 class="font-heading font-semibold text-xl text-gray-700 mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-bmkg-blue rounded-full inline-block"></span>
                Buletin Bulanan
            </h2>

            @if($buletins->isEmpty())
                <p class="text-gray-400">Belum ada buletin tersedia.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($buletins as $pub)
                        <div class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col">
                            <div class="w-full h-36 bg-gradient-to-br from-bmkg-lightblue to-blue-100 flex items-center justify-center">
                                @if($pub->thumbnail)
                                    <img src="{{ asset('storage/'.$pub->thumbnail) }}" alt="{{ $pub->title }}"
                                         class="w-full h-full object-cover"/>
                                @else
                                    <div class="text-4xl">📋</div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs text-gray-400 mb-1">{{ $pub->published_at->format('d M Y') }}</p>
                                <h3 class="font-semibold text-gray-800 text-sm flex-1">{{ $pub->title }}</h3>
                                @if($pub->description)
                                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $pub->description }}</p>
                                @endif
                                @if($pub->file_path || $pub->external_url)
                                    <a href="{{ $pub->file_path ? asset('storage/'.$pub->file_path) : $pub->external_url }}"
                                       target="_blank"
                                       class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-bmkg-blue hover:underline">
                                        ⬇ Unduh
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $buletins->links() }}</div>
            @endif
        </div>

        {{-- Berita --}}
        <div>
            <h2 class="font-heading font-semibold text-xl text-gray-700 mb-6 flex items-center gap-2">
                <span class="w-1 h-6 bg-bmkg-orange rounded-full inline-block"></span>
                Berita
            </h2>

            @if($beritas->isEmpty())
                <p class="text-gray-400">Belum ada berita tersedia.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($beritas as $pub)
                        <div class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col">
                            <div class="w-full h-36 bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center">
                                @if($pub->thumbnail)
                                    <img src="{{ asset('storage/'.$pub->thumbnail) }}" alt="{{ $pub->title }}"
                                         class="w-full h-full object-cover"/>
                                @else
                                    <div class="text-4xl">📰</div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs text-gray-400 mb-1">{{ $pub->published_at->format('d M Y') }}</p>
                                <h3 class="font-semibold text-gray-800 text-sm flex-1">{{ $pub->title }}</h3>
                                @if($pub->description)
                                    <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $pub->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $beritas->links() }}</div>
            @endif
        </div>

    </div>

    {{-- Artikel --}}
    <div id="panel-artikel" class="panel-section hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-10 text-center">
                <div class="text-5xl mb-4">📢</div>
                <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-3">Artikel</h1>
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
        const tab = params.get('tab') || 'buletin';
        switchTab(tab);
    })();
</script>


@endsection
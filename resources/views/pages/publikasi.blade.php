@extends('layouts.app')
@section('title', 'Publikasi - Stasiun Geofisika Kelas III Nabire')

@section('content')

{{-- Navbar --}}
<div class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex gap-1 overflow-x-auto" id="geo-tabs">
            <a href="{{ route('home') }}" id="tab-beranda"
               class="flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Beranda
            </a>
            <button onclick="switchTab('buletin')" id="tab-buletin"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Buletin
            </button>
            <button onclick="switchTab('artikel')" id="tab-artikel"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Artikel
            </button>
        </nav>
    </div>
</div>

<section class="py-10 lg:py-14">

    {{-- ── BULETIN ──────────────────────────────────────────────────────── --}}
    <div id="panel-buletin" class="panel-section max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Buletin Bulanan</h1>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.buletin.index') }}"
                       class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Kelola Buletin
                    </a>
                @endif
            @endauth
        </div>

        @if($buletins->isEmpty())
            <p class="text-gray-400">Belum ada buletin tersedia.</p>
        @else
            {{-- Cover-only grid — click to open PDF viewer --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @foreach($buletins as $bul)
                    @php
                        $pdfUrl = $bul->file_path
                            ? asset('storage/'.$bul->file_path)
                            : $bul->external_url;
                    @endphp
                    <div class="group relative">
                        {{-- Clickable cover --}}
                        @if($pdfUrl)
                            <a href="{{ route('publikasi.pdf-viewer', $bul) }}"
                               class="block rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                        @else
                            <div class="block rounded-2xl overflow-hidden shadow-sm cursor-default">
                        @endif

                            {{-- Cover image (aspect 3:4 like A4) --}}
                            <div class="relative aspect-[3/4] bg-gradient-to-br from-bmkg-lightblue to-blue-100 overflow-hidden">
                                @if($bul->thumbnail)
                                    <img src="{{ asset('storage/'.$bul->thumbnail) }}"
                                         alt="{{ $bul->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center gap-2 p-4">
                                        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span class="text-xs text-blue-400 font-medium text-center leading-tight">{{ $bul->title }}</span>
                                    </div>
                                @endif

                                {{-- PDF hover overlay --}}
                                @if($pdfUrl)
                                    <div class="absolute inset-0 bg-bmkg-blue/0 group-hover:bg-bmkg-blue/60 transition-all duration-300 flex items-center justify-center">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center text-white">
                                            <svg class="w-10 h-10 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span class="text-xs font-semibold">Buka PDF</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        @if($pdfUrl)
                            </a>
                        @else
                            </div>
                        @endif

                        {{-- Title below cover --}}
                        <div class="mt-2 px-1">
                            <p class="text-xs font-semibold text-gray-700 line-clamp-2 leading-tight">{{ $bul->title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $bul->published_at->isoFormat('MMMM YYYY') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $buletins->links() }}</div>
        @endif
    </div>

    {{-- ── ARTIKEL ──────────────────────────────────────────────────────── --}}
    <div id="panel-artikel" class="panel-section hidden max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Artikel</h1>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.artikel.index') }}"
                       class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Kelola Artikel
                    </a>
                @endif
            @endauth
        </div>

        @if($artikels->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm p-10 text-center">
                <div class="text-5xl mb-4">📢</div>
                <p class="text-gray-400">Belum ada artikel tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($artikels as $art)
                    <div class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col">
                        <div class="w-full h-44 bg-gradient-to-br from-bmkg-lightblue to-blue-100 flex items-center justify-center overflow-hidden">
                            @if($art->photo)
                                <img src="{{ asset('storage/'.$art->photo) }}" alt="{{ $art->title }}"
                                     class="w-full h-full object-cover"/>
                            @else
                                <div class="text-5xl">📰</div>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <p class="text-xs text-gray-400 mb-1">{{ $art->published_at->isoFormat('D MMMM YYYY') }}</p>
                            <h3 class="font-semibold text-gray-800 text-sm flex-1">{{ $art->title }}</h3>
                            @if($art->description)
                                <p class="text-xs text-gray-500 mt-2 line-clamp-3">{{ $art->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $artikels->links() }}</div>
        @endif
    </div>

</section>

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
        switchTab(params.get('tab') || 'buletin');
    })();
</script>

@endsection

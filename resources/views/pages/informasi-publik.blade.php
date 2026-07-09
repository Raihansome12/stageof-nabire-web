@extends('layouts.app')
@section('title', 'Informasi Publik - Stasiun Geofisika Kelas III Nabire')
@section('content')

<div class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex gap-1 overflow-x-auto" id="geo-tabs">
            <a href="{{ route('home') }}" id="tab-beranda"
               class="flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Beranda
            </a>
            <button onclick="switchTab('berita')" id="tab-berita"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Berita dan Siaran Pers
            </button>
            <button onclick="switchTab('pengumuman')" id="tab-pengumuman"
                class="tab-btn flex-shrink-0 px-8 py-4 text-sm font-semibold border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-all duration-200 whitespace-nowrap">
                Pengumuman
            </button>
        </nav>
    </div>
</div>

{{-- Berita --}}
<div id="panel-berita" class="panel-section">
    <div class="relative overflow-hidden"
         style="background-image: url('{{ asset('img/bgweb.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0" style="background-color: rgba(255, 255, 255, 0.90);"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Berita dan Siaran Pers</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Ikuti pembaruan berita atau siaran pers terbaru mengenai kegiatan resmi Stasiun Geofisika Kelas III Nabire
            </p>
        </div>
    </div>

    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <!-- <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Berita dan Siaran Pers</h1> -->
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.informasi-publik.create', ['type'=>'berita']) }}"
                        class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Berita
                        </a>
                    @endif
                @endauth
            </div>

            @if($beritas->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm p-10 text-center">
                    <div class="text-5xl mb-4">📰</div>
                    <p class="text-gray-400">Belum ada berita tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($beritas as $item)
                        <a href="{{ route('informasi-publik.show', $item) }}"
                        class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col hover:shadow-lg transition-shadow border border-gray-100">
                            <div class="w-full h-44 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center overflow-hidden">
                                @if($item->photo)
                                    <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->title }}" class="w-full h-full object-cover"/>
                                @else
                                    <div class="text-5xl">📰</div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs text-gray-400 mb-1">{{ $item->published_at->isoFormat('D MMMM YYYY') }}</p>
                                <h3 class="font-semibold text-gray-800 text-sm flex-1">{{ $item->title }}</h3>
                                @if($item->description)
                                    <p class="text-xs text-gray-500 mt-2 line-clamp-3">{{ $item->description }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $beritas->links() }}</div>
            @endif
        </div>
    </section>
</div>

{{-- Pengumuman --}}
<div id="panel-pengumuman" class="panel-section hidden">

    <div class="relative overflow-hidden"
         style="background-image: url('{{ asset('img/bgweb.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0" style="background-color: rgba(255, 255, 255, 0.90);"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Pengumuman</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Dapatkan akses langsung pengumuman penting dan rilis resmi terkait kebijakan, agenda kegiatan, serta informasi Stasiun Geofisika Kelas III Nabire
            </p>
        </div>
    </div>
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <!-- <h1 class="font-heading font-bold text-3xl text-bmkg-blue">Pengumuman</h1> -->
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.informasi-publik.create', ['type'=>'pengumuman']) }}"
                        class="inline-flex items-center gap-2 text-xs bg-amber-500 text-white px-3 py-2 rounded-lg hover:opacity-90 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambah Pengumuman
                        </a>
                    @endif
                @endauth
            </div>

            @if($pengumumans->isEmpty())
                <div class="bg-bmkg-lightblue rounded-2xl shadow-sm p-10 text-center border border-blue-100">
                    <div class="text-5xl mb-4">📢</div>
                    <p class="text-gray-400">Belum ada pengumuman tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pengumumans as $item)
                        <a href="{{ route('informasi-publik.show', $item) }}"
                        class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col hover:shadow-lg transition-shadow border border-gray-100">
                            <div class="w-full h-44 bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center overflow-hidden">
                                @if($item->photo)
                                    <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->title }}" class="w-full h-full object-cover"/>
                                @else
                                    <div class="text-5xl">📢</div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <p class="text-xs text-gray-400 mb-1">{{ $item->published_at->isoFormat('D MMMM YYYY') }}</p>
                                <h3 class="font-semibold text-gray-800 text-sm flex-1">{{ $item->title }}</h3>
                                @if($item->description)
                                    <p class="text-xs text-gray-500 mt-2 line-clamp-3">{{ $item->description }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-6">{{ $pengumumans->links() }}</div>
            @endif
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
        switchTab(params.get('tab') || 'berita');
    })();
</script>

@endsection

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


{{--Buletin--}}
<div id="panel-buletin" class="panel-section">
    <div class="relative overflow-hidden"
         style="background-image: url('{{ asset('img/bgweb.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0" style="background-color: rgba(255, 255, 255, 0.90);"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Buletin</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Simak buletin berkala kami untuk mendapatkan rangkuman informasi, laporan kegiatan, dan analisis mendalam secara komprehensif.
            </p>
        </div>
    </div>
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
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
                {{-- Cover-only grid — click to open PDF modal --}}
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
                                {{-- Changed from <a> to <button> to trigger modal --}}
                                <button type="button" onclick="openPdfModal('{{ addslashes($bul->title) }}', '{{ $pdfUrl }}')"
                                class="w-full text-left block rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
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
                                </button>
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
    </section>
</div>

{{-- Artikel --}}
<div id="panel-artikel" class="panel-section hidden">
    <div class="relative overflow-hidden"
         style="background-image: url('{{ asset('img/bgweb.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0" style="background-color: rgba(255, 255, 255, 0.90);"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Artikel</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Jelajahi berbagai artikel edukatif dan ulasan menarik untuk memperluas wawasan Anda mengenai literasi kebencanaan dan sains geofisika.
            </p>
        </div>
    </div>
    <section class="py-10 lg:py-14 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
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
                <div class="bg-bmkg-lightblue rounded-2xl border border-blue-100 shadow-sm p-10 text-center">
                    <div class="text-5xl mb-4">📢</div>
                    <p class="text-gray-400">Belum ada artikel tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($artikels as $art)
                        <a href="{{ route('artikel.show', $art) }}"
                        class="info-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col hover:shadow-lg transition-shadow">
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
                        </a>
                    @endforeach
                </div>
                <div class="mt-8">{{ $artikels->links() }}</div>
            @endif
        </div>
    </section>
</div>

{{-- ================= PDF MODAL VIEWER ================= --}}
<div id="documentModal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="modalContent">
        
        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="font-semibold text-gray-800 line-clamp-1" id="modalTitle">Dokumen Buletin</h3>
            <div class="flex items-center gap-4">
                <a href="#" id="modalDownloadBtn" target="_blank" class="text-sm font-medium text-bmkg-blue hover:underline">Buka di Tab Baru</a>
                <button onclick="closePdfModal()" class="text-gray-500 hover:text-red-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex-1 w-full bg-gray-200 relative">
            {{-- Loading spinner while iframe loads --}}
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none" id="iframeLoader">
                <svg class="w-8 h-8 text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            <iframe 
                id="modalIframe"
                src="" 
                class="w-full h-full border-0 relative z-10"
                allow="autoplay"
                onload="document.getElementById('iframeLoader').style.display='none';">
            </iframe>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    // ── Tab switching ──────────────────────────────────────────────────────────
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

    // ── PDF Modal Functionality ───────────────────────────────────────────────
    const modal = document.getElementById('documentModal');
    const modalContent = document.getElementById('modalContent');
    const modalIframe = document.getElementById('modalIframe');
    const modalTitle = document.getElementById('modalTitle');
    const modalDownloadBtn = document.getElementById('modalDownloadBtn');
    const iframeLoader = document.getElementById('iframeLoader');

    function openPdfModal(title, url) {
        // Set Title and Download Link
        modalTitle.textContent = title;
        modalDownloadBtn.href = url;
        
        // Show loader
        iframeLoader.style.display = 'flex';

        // Format Google Drive Links to ensure they use /preview for iframes
        let iframeUrl = url;
        if (url.includes('drive.google.com')) {
            iframeUrl = url.replace(/\/view(\?usp=sharing)?$/, '/preview');
        }

        // Set iframe source
        modalIframe.src = iframeUrl;

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
            modalIframe.src = ''; // Clear iframe to stop loading/audio
        }, 300); 
    }

    // Close modal if user clicks outside the white box (on the dark background)
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closePdfModal();
        }
    });
</script>

@endsection
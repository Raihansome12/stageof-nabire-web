{{-- ============================================================
     PANEL: Informasi Hilal
     Data: $latestHilal (single latest active record, from
     HomeController::informasiGeofisika)
     Two boxes: left = image carousel (up to 3 images, with prev/next),
     right = PDF viewer for the latest hilal bulletin.
     ============================================================ --}}
<div id="panel-hilal" class="panel-section hidden">
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-center border-b border-gray-200">
            <h1 class="font-heading font-bold text-3xl text-bmkg-blue mb-2">Informasi Hilal</h1>
            <p class="text-gray-500 text-sm max-w-xl mx-auto">
                Rujukan resmi dan terkini untuk data astronomi posisi bulan,
                livestreaming observasi lapangan, serta pembaruan status hilal di seluruh Indonesia
            </p>
        </div>
    </div>

    <section class="py-8 lg:py-10 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Admin quick-edit bar --}}
            <div class="flex items-center justify-between mb-5">
                <div></div>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.hilal.index') }}"
                           class="inline-flex items-center gap-2 text-xs bg-bmkg-blue text-white px-3 py-2 rounded-lg hover:opacity-90 transition-opacity shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Kelola Informasi Hilal
                        </a>
                    @endif
                @endauth
            </div>

            @if(! $latestHilal)
                <p class="text-gray-400">Belum ada informasi hilal tersedia.</p>
            @else
                @php
                    // thumbnail is dedicated to the PDF cover (Box 2) — the gallery
                    // (Box 1) only shows image_2 and image_3.
                    $hilalImages = collect([$latestHilal->image_2, $latestHilal->image_3])
                        ->filter()->values()->toArray();
                    $hilalPdfUrl = $latestHilal->file_path
                        ? asset('storage/'.$latestHilal->file_path)
                        : $latestHilal->external_url;
                @endphp

                <div class="mb-6">
                    <h2 class="font-heading font-bold text-lg text-bmkg-black">{{ $latestHilal->title }}</h2>
                    <p class="text-xs text-gray-400 mt-1">{{ $latestHilal->published_at->isoFormat('D MMMM YYYY') }}</p>
                    @if($latestHilal->description)
                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $latestHilal->description }}</p>
                    @endif
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 ">
                    {{-- ── Box 1: Image carousel ─────────────────────────── --}}
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
                        @if(count($hilalImages))
                            <div class="relative flex-1">
                                <div class="relative aspect-[3/2] overflow-hidden w-full h-full">
                                    @foreach($hilalImages as $i => $img)
                                        <img src="{{ asset('storage/'.$img) }}"
                                            alt="{{ $latestHilal->title }} — Gambar {{ $i + 1 }}"
                                            class="hilal-carousel-img absolute inset-0 w-full h-full object-contain transition-opacity duration-300 {{ $i === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none' }}"
                                            data-index="{{ $i }}"/>
                                    @endforeach
                                </div>

                                @if(count($hilalImages) > 1)
                                    <button type="button" onclick="hilalPrevImage()"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-700 rounded-full w-9 h-9 flex items-center justify-center shadow-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                    </button>
                                    <button type="button" onclick="hilalNextImage()"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-700 rounded-full w-9 h-9 flex items-center justify-center shadow-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                    </button>

                                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5">
                                        @foreach($hilalImages as $i => $img)
                                            <button type="button" onclick="hilalGoToImage({{ $i }})"
                                                    id="hilal-dot-{{ $i }}"
                                                    class="hilal-dot w-2 h-2 rounded-full transition-colors {{ $i === 0 ? 'bg-bmkg-blue' : 'bg-white/70 border border-gray-300' }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="aspect-[4/3] flex flex-col items-center justify-center gap-2 text-gray-300 flex-1">
                                <span class="text-4xl">🌙</span>
                                <span class="text-xs">Belum ada gambar</span>
                            </div>
                        @endif
                    </div>

                    {{-- ── Box 2: PDF cover (Stretches automatically to match Box 1) ── --}}
                    <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col h-full">
                        @if($hilalPdfUrl)
                            <button type="button"
                                    onclick="openHilalPdfModal('{{ addslashes($latestHilal->title) }}', '{{ $hilalPdfUrl }}')"
                                    class="group relative flex-1 w-full h-full bg-gray-100 text-left">
                                @if($latestHilal->thumbnail)
                                    <img src="{{ asset('storage/'.$latestHilal->thumbnail) }}"
                                        alt="Cover {{ $latestHilal->title }}"
                                        class="absolute inset-0 w-full h-full object-cover"/>
                                @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 p-4 bg-gradient-to-br from-bmkg-lightblue to-blue-100">
                                        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span class="text-xs text-blue-400 font-medium text-center leading-tight">{{ $latestHilal->title }}</span>
                                    </div>
                                @endif

                                {{-- Hover overlay --}}
                                <div class="absolute inset-0 bg-bmkg-blue/0 group-hover:bg-bmkg-blue/60 transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center text-white">
                                        <svg class="w-10 h-10 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="text-xs font-semibold">Buka PDF</span>
                                    </div>
                                </div>
                            </button>
                        @else
                            <div class="flex-1 w-full h-full flex flex-col items-center justify-center gap-2 text-gray-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="text-xs">Belum ada dokumen PDF</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Info box: link to national hilal info page --}}
            <div class="mt-8 border-t border-gray-200 pt-8">
                {{-- Info box: banner link to national earthquake archive --}}
                <a href="https://hilal.bmkg.go.id/" 
                target="_blank" 
                rel="noopener" 
                class="block overflow-hidden rounded-xl transition-all duration-200 hover:opacity-95 hover:-translate-y-1 hover:shadow-md border border-gray-200">
                    <img src="{{ asset('img/hilal-info.png') }}" 
                        alt="Pusat Arsip Data Kegempaan BMKG" 
                        class="w-full h-auto object-cover">
                </a>
            </div>

        </div>
    </section>
</div>{{-- end #panel-hilal --}}

{{-- ================= PDF MODAL VIEWER (Informasi Hilal) ================= --}}
<div id="hilalPdfModal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="hilalModalContent">

        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="font-semibold text-gray-800 line-clamp-1" id="hilalModalTitle">Dokumen Hilal</h3>
            <div class="flex items-center gap-4">
                <a href="#" id="hilalModalDownloadBtn" target="_blank" rel="noopener" class="text-sm font-medium text-bmkg-blue hover:underline">Buka di Tab Baru</a>
                <button onclick="closeHilalPdfModal()" class="text-gray-500 hover:text-red-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex-1 w-full bg-gray-200 relative">
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none" id="hilalIframeLoader">
                <svg class="w-8 h-8 text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <iframe
                id="hilalModalIframe"
                src=""
                class="w-full h-full border-0 relative z-10"
                allow="autoplay"
                onload="document.getElementById('hilalIframeLoader').style.display='none';">
            </iframe>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ── Informasi Hilal: image carousel ─────────────────────────────────────
    let hilalImgIndex = 0;
    const hilalImgEls = document.querySelectorAll('.hilal-carousel-img');

    function hilalShowImage(idx) {
        if (!hilalImgEls.length) return;
        hilalImgIndex = (idx + hilalImgEls.length) % hilalImgEls.length;
        hilalImgEls.forEach((img, i) => {
            img.classList.toggle('opacity-100', i === hilalImgIndex);
            img.classList.toggle('opacity-0', i !== hilalImgIndex);
            img.classList.toggle('pointer-events-none', i !== hilalImgIndex);
        });
        document.querySelectorAll('.hilal-dot').forEach((dot, i) => {
            dot.classList.toggle('bg-bmkg-blue', i === hilalImgIndex);
            dot.classList.toggle('bg-white/70', i !== hilalImgIndex);
            dot.classList.toggle('border', i !== hilalImgIndex);
            dot.classList.toggle('border-gray-300', i !== hilalImgIndex);
        });
        const counter = document.getElementById('hilal-img-counter');
        if (counter) counter.textContent = (hilalImgIndex + 1) + ' / ' + hilalImgEls.length;
    }

    function hilalNextImage() { hilalShowImage(hilalImgIndex + 1); }
    function hilalPrevImage() { hilalShowImage(hilalImgIndex - 1); }
    function hilalGoToImage(idx) { hilalShowImage(idx); }

    // ── Informasi Hilal: PDF popup modal (same pattern as Buletin) ──────────
    const hilalModal        = document.getElementById('hilalPdfModal');
    const hilalModalContent = document.getElementById('hilalModalContent');
    const hilalModalIframe  = document.getElementById('hilalModalIframe');
    const hilalModalTitle   = document.getElementById('hilalModalTitle');
    const hilalModalDlBtn   = document.getElementById('hilalModalDownloadBtn');
    const hilalIframeLoader = document.getElementById('hilalIframeLoader');

    function openHilalPdfModal(title, url) {
        hilalModalTitle.textContent = title;
        hilalModalDlBtn.href = url;
        hilalIframeLoader.style.display = 'flex';

        let iframeUrl = url;
        if (url.includes('drive.google.com')) {
            iframeUrl = url.replace(/\/view(\?usp=sharing)?$/, '/preview');
        }
        hilalModalIframe.src = iframeUrl;

        hilalModal.classList.remove('hidden');
        setTimeout(() => {
            hilalModal.classList.remove('opacity-0');
            hilalModalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeHilalPdfModal() {
        hilalModal.classList.add('opacity-0');
        hilalModalContent.classList.add('scale-95');
        setTimeout(() => {
            hilalModal.classList.add('hidden');
            hilalModalIframe.src = '';
        }, 300);
    }

    hilalModal.addEventListener('click', function (event) {
        if (event.target === hilalModal) closeHilalPdfModal();
    });
</script>
@endpush

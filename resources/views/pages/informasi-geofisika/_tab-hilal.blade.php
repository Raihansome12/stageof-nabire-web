{{-- ============================================================
     PANEL: Informasi Hilal
     Data: $hilals (paginated, from HomeController::informasiGeofisika)
     Design mirrors the Buletin grid on pages/publikasi.blade.php
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

            {{-- Info box: link to national hilal info page --}}
            <div class="flex items-start gap-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3.5 mb-8 text-sm text-blue-800">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p>
                    Untuk informasi hilal lebih lanjut dapat mengunjungi laman
                    <a href="https://hilal.bmkg.go.id/" target="_blank" rel="noopener" class="font-semibold underline hover:text-blue-900">hilal.bmkg.go.id/</a>.
                </p>
            </div>

            @if($hilals->isEmpty())
                <p class="text-gray-400">Belum ada informasi hilal tersedia.</p>
            @else
                {{-- Cover-only grid — click to open PDF modal --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                    @foreach($hilals as $h)
                        @php
                            $pdfUrl = $h->file_path
                                ? asset('storage/'.$h->file_path)
                                : $h->external_url;
                        @endphp
                        <div class="group relative">
                            {{-- Clickable cover --}}
                            @if($pdfUrl)
                                <button type="button" onclick="openHilalPdfModal('{{ addslashes($h->title) }}', '{{ $pdfUrl }}')"
                                class="w-full text-left block rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            @else
                                <div class="block rounded-2xl overflow-hidden shadow-sm cursor-default">
                            @endif

                                {{-- Cover image (aspect 3:4 like A4) --}}
                                <div class="relative aspect-[3/4] bg-gradient-to-br from-bmkg-lightblue to-blue-100 overflow-hidden">
                                    @if($h->thumbnail)
                                        <img src="{{ asset('storage/'.$h->thumbnail) }}"
                                            alt="{{ $h->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center gap-2 p-4">
                                            <span class="text-3xl">🌙</span>
                                            <span class="text-xs text-blue-400 font-medium text-center leading-tight">{{ $h->title }}</span>
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
                                <p class="text-xs font-semibold text-gray-700 line-clamp-2 leading-tight">{{ $h->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $h->published_at->isoFormat('D MMMM YYYY') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">{{ $hilals->links() }}</div>
            @endif
        </div>
    </section>
</div>{{-- end #panel-hilal --}}

{{-- ================= PDF MODAL VIEWER (Hilal) ================= --}}
<div id="hilalDocumentModal" class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300" id="hilalModalContent">

        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="font-semibold text-gray-800 line-clamp-1" id="hilalModalTitle">Dokumen Hilal</h3>
            <div class="flex items-center gap-4">
                <a href="#" id="hilalModalDownloadBtn" target="_blank" class="text-sm font-medium text-bmkg-blue hover:underline">Buka di Tab Baru</a>
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
    // ── Informasi Hilal: PDF modal ──────────────────────────────────────────
    const hilalModal = document.getElementById('hilalDocumentModal');
    const hilalModalContent = document.getElementById('hilalModalContent');
    const hilalModalIframe = document.getElementById('hilalModalIframe');
    const hilalModalTitle = document.getElementById('hilalModalTitle');
    const hilalModalDownloadBtn = document.getElementById('hilalModalDownloadBtn');
    const hilalIframeLoader = document.getElementById('hilalIframeLoader');

    function openHilalPdfModal(title, url) {
        hilalModalTitle.textContent = title;
        hilalModalDownloadBtn.href = url;
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

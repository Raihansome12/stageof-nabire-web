{{--
    Bulk-action toolbar
    Props (set via php block before @include):
      $bulkRoute  — named route for POST bulk-destroy
      $entityName — human-readable label e.g. "artikel", "pegawai"
--}}
<div id="bulkBar"
     class="hidden sticky top-0 z-20 bg-red-50 border border-red-200 rounded-xl px-4 py-3
            flex items-center justify-between gap-4 mb-4 shadow-sm transition-all">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <span class="text-sm font-semibold text-red-800">
            <span id="bulkCount">0</span> {{ $entityName }} dipilih
        </span>
    </div>
    <div class="flex items-center gap-2">
        <button type="button" onclick="clearSelection()"
                class="text-xs px-3 py-1.5 border border-red-300 text-red-700 rounded-lg hover:bg-red-100 transition-colors font-medium">
            Batalkan
        </button>
        <form id="bulkForm" method="POST" action="{{ route($bulkRoute) }}">
            @csrf
            @method('DELETE')
            <div id="bulkInputs"></div>
            <button type="button" onclick="submitBulkDelete()"
                    class="text-xs px-4 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                Hapus yang Dipilih
            </button>
        </form>
    </div>
</div>

@extends('admin.layout')
@section('title', 'Permohonan Data Masyarakat')
@section('page-title', 'Permohonan Data Masyarakat')

@section('content')

{{-- Bulk bar --}}
@php $bulkRoute = 'admin.permohonan-data.bulk-destroy'; $entityName = 'permohonan'; @endphp
@include('admin.partials.bulk-bar')

{{-- Stats cards --}}
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $counts['total'] }}</p>
            <p class="text-xs text-gray-500">Total Permohonan</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $counts['baru'] }}</p>
            <p class="text-xs text-gray-500">Belum Diproses</p>
        </div>
    </div>
</div>

{{-- Filter & search --}}
<form method="GET" action="{{ route('admin.permohonan-data.index') }}"
      class="flex flex-wrap gap-2 mb-4 items-center">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama, instansi, no HP..."
           class="border rounded-lg px-3 py-2 text-sm focus:ring-bmkg-blue focus:border-bmkg-blue flex-1 min-w-[200px]">
    <select name="status" class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua Status</option>
        <option value="baru"      {{ request('status') === 'baru'      ? 'selected' : '' }}>Baru</option>
        <option value="diproses"  {{ request('status') === 'diproses'  ? 'selected' : '' }}>Diproses</option>
        <option value="selesai"   {{ request('status') === 'selesai'   ? 'selected' : '' }}>Selesai</option>
        <option value="ditolak"   {{ request('status') === 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
    </select>
    <select name="jenis" class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua Jenis</option>
        <option value="pnbp" {{ request('jenis') === 'pnbp' ? 'selected' : '' }}>PNBP</option>
        <option value="nol"  {{ request('jenis') === 'nol'  ? 'selected' : '' }}>Tarif Nol Rupiah</option>
    </select>
    <button type="submit"
            class="bg-bmkg-blue text-white text-sm px-4 py-2 rounded-lg hover:opacity-90 transition">
        Cari
    </button>
    @if(request()->hasAny(['search','status','jenis']))
        <a href="{{ route('admin.permohonan-data.index') }}"
           class="text-sm text-gray-500 underline px-2 py-2">Reset</a>
    @endif
</form>

{{-- Flash --}}
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Table --}}
@if($permohonan->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400 text-sm">
        Belum ada permohonan data masuk.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 w-10">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer" onchange="toggleSelectAll(this)">
                    </th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Pemohon</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">Jenis Data</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden sm:table-cell">Permohonan</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden lg:table-cell">Tanggal</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($permohonan as $item)
                    @php $badge = $item->badgeStatus(); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <input type="checkbox" class="row-cb rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer" value="{{ $item->id }}">
                        </td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-800 leading-tight">{{ $item->nama_lengkap }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->instansi }}</p>
                            <p class="text-xs text-gray-400">{{ $item->no_hp }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-600 hidden md:table-cell max-w-[180px]">
                            <div class="line-clamp-2">{{ $item->jenis_data }}</div>
                        </td>
                        <td class="px-5 py-3 hidden sm:table-cell">
                            <span class="inline-block text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $item->jenis_permohonan === 'pnbp'
                                    ? 'bg-purple-100 text-purple-700'
                                    : 'bg-teal-100 text-teal-700' }}">
                                {{ $item->labelJenisPermohonan() }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-500 hidden lg:table-cell whitespace-nowrap text-xs">
                            {{ $item->created_at->setTimezone('Asia/Jayapura')->format('d M Y') }}<br>
                            {{ $item->created_at->setTimezone('Asia/Jayapura')->format('H:i') }} WIT
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-full font-medium {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.permohonan-data.show', $item) }}"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100">
                                   Detail
                                </a>
                                <a href="{{ route('admin.permohonan-data.pdf-detail', $item) }}"
                                   target="_blank"
                                   title="Lihat PDF Detail Pemohon"
                                   class="inline-flex items-center justify-center w-7 h-7 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                                <button onclick="confirmDelete('{{ route('admin.permohonan-data.destroy', $item) }}')"
                                        class="text-xs px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $permohonan->links() }}</div>
@endif

@endsection

@push('scripts')
@include('admin.partials.bulk-js')
<script>
function confirmDelete(url) {
    if (!confirm('Hapus permohonan ini? Tindakan ini tidak dapat dibatalkan.')) return;
    const f = document.createElement('form');
    f.method = 'POST'; f.action = url;
    f.innerHTML = `@csrf @method('DELETE')`;
    document.body.appendChild(f);
    f.submit();
}
</script>
@endpush

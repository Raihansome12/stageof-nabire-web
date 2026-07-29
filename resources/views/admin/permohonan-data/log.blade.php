@extends('admin.layout')
@section('title', 'Log Permohonan Data')
@section('page-title', 'Log Permohonan Data')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.permohonan-data.index') }}"
       class="text-sm text-bmkg-blue hover:underline flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Daftar Permohonan
    </a>
</div>

<div class="bg-blue-50 border border-blue-100 text-blue-800 rounded-xl px-4 py-3 mb-4 text-sm">
    Halaman ini mencatat setiap perubahan status pada permohonan data masuk — kapan status
    diubah (Diproses / Belum Dibayar / Sudah Dibayar / Selesai / Ditolak) dan admin mana yang
    melakukannya. Berguna untuk melacak proses bila terjadi pergantian petugas di tengah jalan.
</div>

{{-- Filter & search --}}
<form method="GET" action="{{ route('admin.permohonan-data.log') }}"
      class="flex flex-wrap gap-2 mb-4 items-center">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama pemohon / instansi..."
           class="border rounded-lg px-3 py-2 text-sm focus:ring-bmkg-blue focus:border-bmkg-blue flex-1 min-w-[200px]">
    <select name="status" class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua Status</option>
        <option value="baru"          {{ request('status') === 'baru'          ? 'selected' : '' }}>Baru</option>
        <option value="diproses"      {{ request('status') === 'diproses'      ? 'selected' : '' }}>Diproses</option>
        <option value="belum dibayar" {{ request('status') === 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
        <option value="sudah dibayar" {{ request('status') === 'sudah dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
        <option value="selesai"       {{ request('status') === 'selesai'       ? 'selected' : '' }}>Selesai</option>
        <option value="ditolak"       {{ request('status') === 'ditolak'       ? 'selected' : '' }}>Ditolak</option>
    </select>
    <select name="admin_id" class="border rounded-lg px-3 py-2 text-sm">
        <option value="">Semua Admin</option>
        @foreach($admins as $admin)
            <option value="{{ $admin->id }}" {{ (string) request('admin_id') === (string) $admin->id ? 'selected' : '' }}>
                {{ $admin->name }}
            </option>
        @endforeach
    </select>
    <button type="submit"
            class="bg-bmkg-blue text-white text-sm px-4 py-2 rounded-lg hover:opacity-90 transition">
        Cari
    </button>
    @if(request()->hasAny(['search','status','admin_id']))
        <a href="{{ route('admin.permohonan-data.log') }}"
           class="text-sm text-gray-500 underline px-2 py-2">Reset</a>
    @endif
</form>

{{-- Table --}}
@if($logs->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400 text-sm">
        Belum ada riwayat perubahan status.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Pemohon</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Perubahan Status</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Admin</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden lg:table-cell">Catatan</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">Waktu</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($logs as $log)
                    @php $badge = $log->badgeStatus(); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            @if($log->permohonanData)
                                <p class="font-medium text-gray-800 leading-tight">{{ $log->permohonanData->nama_lengkap }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $log->permohonanData->instansi }}</p>
                            @else
                                <span class="text-xs text-gray-400 italic">Permohonan telah dihapus</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-xs text-gray-400">{{ $log->labelStatusSebelumnya() }} →</span>
                                <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badge['class'] }}">
                                    {{ $badge['label'] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-700">
                            {{ $log->admin->name ?? '—' }}
                        </td>
                        <td class="px-5 py-3 text-gray-500 hidden lg:table-cell max-w-[220px]">
                            <div class="line-clamp-2">{{ $log->catatan ?: '—' }}</div>
                        </td>
                        <td class="px-5 py-3 text-gray-500 hidden md:table-cell whitespace-nowrap text-xs">
                            {{ $log->created_at->setTimezone('Asia/Jayapura')->format('d M Y') }}<br>
                            {{ $log->created_at->setTimezone('Asia/Jayapura')->format('H:i') }} WIT
                        </td>
                        <td class="px-5 py-3 text-right">
                            @if($log->permohonanData)
                                <a href="{{ route('admin.permohonan-data.show', $log->permohonanData) }}"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100">
                                   Detail
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $logs->links() }}</div>
@endif

@endsection

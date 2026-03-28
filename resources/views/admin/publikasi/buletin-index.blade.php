@extends('admin.layout')
@section('title', 'Kelola Buletin')
@section('page-title', 'Buletin Bulanan')

@section('content')

{{-- Bulk bar --}}
@php $bulkRoute = 'admin.buletin.bulk-destroy'; $entityName = 'buletin'; @endphp
@include('admin.partials.bulk-bar')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-2 text-xs text-gray-500">
        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
               class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"/>
        <label for="selectAll" class="cursor-pointer">Pilih Semua</label>
    </div>
    <a href="{{ route('admin.buletin.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Buletin
    </a>
</div>

@if($buletins->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400">
        Belum ada buletin. Klik "Tambah Buletin" untuk mulai.
    </div>
@else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
        @foreach($buletins as $bul)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col relative">
                {{-- Checkbox --}}
                <div class="absolute top-2 left-2 z-10">
                    <input type="checkbox" class="row-cb w-4 h-4 rounded border-gray-300 bg-white/80 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer" value="{{ $bul->id }}"/>
                </div>
                {{-- Cover --}}
                <div class="relative aspect-[3/4] bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center overflow-hidden">
                    @if($bul->thumbnail)
                        <img src="{{ asset('storage/'.$bul->thumbnail) }}" alt="{{ $bul->title }}"
                             class="w-full h-full object-cover"/>
                    @else
                        <div class="text-center p-4">
                            <div class="text-4xl mb-2">📋</div>
                            <div class="text-xs text-blue-400 font-medium">No Cover</div>
                        </div>
                    @endif
                    {{-- Status badge --}}
                    <div class="absolute top-2 right-2">
                        @if($bul->is_active)
                            <span class="text-xs bg-green-500 text-white px-2 py-0.5 rounded-full">Aktif</span>
                        @else
                            <span class="text-xs bg-gray-400 text-white px-2 py-0.5 rounded-full">Draft</span>
                        @endif
                    </div>
                    {{-- PDF indicator --}}
                    @if($bul->file_path || $bul->external_url)
                        <div class="absolute bottom-2 left-2">
                            <span class="text-xs bg-red-500 text-white px-2 py-0.5 rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                                PDF
                            </span>
                        </div>
                    @endif
                </div>
                <div class="p-3">
                    <p class="text-xs font-semibold text-gray-800 line-clamp-2 leading-tight mb-1">{{ $bul->title }}</p>
                    <p class="text-xs text-gray-400">{{ $bul->published_at->format('M Y') }}</p>
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('admin.buletin.edit', $bul) }}"
                           class="flex-1 text-center text-xs py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100 transition-colors">Edit</a>
                        <button onclick="confirmDelete('{{ route('admin.buletin.destroy', $bul) }}')"
                                class="flex-1 text-xs py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100 transition-colors">Hapus</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $buletins->links() }}</div>
@endif
@endsection

@push('scripts')
@include('admin.partials.bulk-js')
@endpush

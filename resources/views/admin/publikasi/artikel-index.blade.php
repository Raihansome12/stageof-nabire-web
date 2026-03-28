@extends('admin.layout')
@section('title', 'Kelola Artikel')
@section('page-title', 'Artikel')

@section('content')

{-- Bulk bar --}
@php $bulkRoute = 'admin.artikel.bulk-destroy'; $entityName = 'artikel'; @endphp
@include('admin.partials.bulk-bar')
<div class="flex items-center justify-end mb-6">
    <a href="{{ route('admin.artikel.create') }}"
       class="inline-flex items-center gap-2 bg-bmkg-blue text-white text-sm font-medium px-4 py-2.5 rounded-lg hover:opacity-90 transition-opacity">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Artikel
    </a>
</div>

@if($artikels->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center text-gray-400">
        Belum ada artikel. Klik "Tambah Artikel" untuk mulai.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 w-10"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" class="rounded border-gray-300 text-bmkg-blue focus:ring-bmkg-blue cursor-pointer"/></th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 w-16">Foto</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Judul</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">Deskripsi</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden sm:table-cell">Tanggal</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($artikels as $artikel)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-5 py-3">
                            @if($artikel->photo)
                                <img src="{{ asset('storage/'.$artikel->photo) }}" alt="{{ $artikel->title }}"
                                     class="w-12 h-12 object-cover rounded-lg border border-gray-200"/>
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-xl">📰</div>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-800 max-w-xs">
                            <div class="line-clamp-2">{{ $artikel->title }}</div>
                        </td>
                        <td class="px-5 py-3 text-gray-500 hidden md:table-cell max-w-xs">
                            <div class="line-clamp-2">{{ $artikel->description ?? '-' }}</div>
                        </td>
                        <td class="px-5 py-3 text-gray-500 hidden sm:table-cell whitespace-nowrap">
                            {{ $artikel->published_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3">
                            @if($artikel->is_active)
                                <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.artikel.edit', $artikel) }}"
                                   class="text-xs px-3 py-1.5 bg-blue-50 text-blue-700 font-medium rounded-lg hover:bg-blue-100 transition-colors">Edit</a>
                                <button onclick="confirmDelete('{{ route('admin.artikel.destroy', $artikel) }}')"
                                        class="text-xs px-3 py-1.5 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100 transition-colors">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">{{ $artikels->links() }}</div>
@endif
@endsection

@push('scripts')
@include('admin.partials.bulk-js')
@endpush
